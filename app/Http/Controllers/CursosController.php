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
}
