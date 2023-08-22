<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cursos;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CursosController extends Controller
{
    //retornar la vista de cursos.blade.php
    public function index(){
        //all(), select * from courses
        //$cursos = Cursos::all();
        /**
         * consulta para obtener el nombre del instructor y la informacion del curso #inner join (join laravel), ON 
         * 
         * SELECT courses.*, instructor.name AS instructor FROM courses INNER JOIN instructor ON courses.id_instructor = instructor.id;
         * 
         * INNER JOIN => join()
         * SELECT => select()->get()
         * 
         * WHERE => where()
         */
        $cursos = Cursos::join('instructor', 'courses.id_instructor', '=', 'instructor.id')->select('courses.*','instructor.name AS instructor')->get();
        return view('paginas.cursos', array("cursos" => $cursos));
    }

    //retornar el formulario de registro para el curso con la lista de instructores de bd
    public function getForm(){
        //select * from instructor

        //DB::("SELECT * FROM instructor");
        //DB::select('*', 'instructores')
        /**
         * queryBuilder
         * ORM => (Mapeo Relacion de Objetos)
         * all() => select * from table
         * save() => insert into...
         * update()
         * delete()
         * []
         */
        $instructores = Instructor::all(); //select * from table
        //select name, email from instructor
        //Instructor::select('name', 'email')->get();
        return view('paginas.registrar_curso', array("instructores" => $instructores));
    }

    //metodo para registrar un curso
    public function store(Request $request){
        //validando la entrada de imagenes
        //true, false
        if($request->hasFile('imagen')){
            $imagen = $request->file('imagen'); //imagen1.jpg

            //formatear el nombre de la imagen
            //kenia / @k$456

            //react JS - react-js.jpg
            $nombre_imagen = Str::slug($request->post('titulo')).".".$imagen->guessExtension();

            //asignamos la ruta donde se van a guardar las imagenes
            $ruta = public_path("img/");
            //public/
            //hacemos una copia del archivo y lo almacenamos en la ruta img
            copy($imagen->getRealPath(), $ruta.$nombre_imagen);
            //public/img/react-js.jpg
        }else{
            $nombre_imagen = null;
        }

        //insert into table(campos) values (valores) => save()
        $cursos = new Cursos();
        $cursos->title = $request->post('titulo');
        $cursos->description = $request->post('descripcion');
        $cursos->price = $request->post('precio');
        $cursos->imagen = $nombre_imagen;
        $cursos->id_instructor = $request->post('instructor');
        $cursos->save();
        //insert into courses(title, description, price, imagen, id_instructor) VALUES ()

        return redirect()->route('cursos');
    }
    //CRUD => index() (leer), store() (crear), update() actualizar, destroy() eliminar

    //retornar vista con los datos de un curso en especifico
    public function editar($id){
        //select * from courses where id = 4 => find()
        //$curso = Cursos::find($id);
        //select * from courses where nombre = 'Laravel' limit 1
        //Cursos::select('*')->where('nombre', '=', 'Laravel')->limit(1);


        /**
         * select courses.*, instructor.name from courses INNER JOIN instructor ON courses.id_instructor = instructor.id where courses.id = ?;
         */
        $curso = Cursos::join('instructor', 'courses.id_instructor', '=', 'instructor.id')->select('courses.*','instructor.name')->find($id);
        //select * from instructor => all() select * from table
        $instructores = Instructor::all();
        return view("paginas.editar_curso", array("curso" => $curso, "instructores" => $instructores));
    }

    //metodo para actualizar el curso
    public function update(Request $request, $id){
        if($request->hasFile('imagen')){ //true

            $imagen = $request->file('imagen'); //laravel-10.jpg
            $nombre_imagen = Str::slug($request->post('titulo')).".".$imagen->guessExtension();

            //asignamos la ruta donde se van a guardar las imagenes
            $ruta = public_path("img/");
            //public/
            //hacemos una copia del archivo y lo almacenamos en la ruta img
            copy($imagen->getRealPath(), $ruta.$nombre_imagen);
            //public/img/react-js.jpg
        }else{
            $nombre_imagen = $request->post('imagen_previa'); //laravel-10.jpg
        }

        //select * from courses where id = $id
        $cursos = Cursos::find($id);
        $cursos->title = $request->post('titulo'); //Laravel y migraciones
        $cursos->description = $request->post('descripcion'); //este curso aprenderas la base para crear proyectos con laravel 10
        $cursos->price = $request->post('precio'); //14.99
        $cursos->imagen = $nombre_imagen; //laravel-10.jpg
        $cursos->id_instructor = $request->post('instructor'); //3
        //update table set title = 'react' ... where id = ?
        $cursos->update();

        return redirect()->route('cursos');
    }

    //metodo para eliminar un curso
    public function destroy($id){
        //delete from courses where id = ?

        /**
         * id_estado = 1 = activo
         * id_estado = 2 = inactivo
         * 
         * update courses set id_estado = 2 where id = 4
         * $cursos = Cursos::find($id);
         * $cursos->id_estado = $request->post('estado');
         * $cursos->update();
         */
        $curso = Cursos::where('id', '=', $id)->delete();

        /*DB::table('courses')
                ->where('id', '=', $id)
                ->delete();*/

        return redirect()->route('cursos');
    }
}
