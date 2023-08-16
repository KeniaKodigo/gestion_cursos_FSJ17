<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Instructor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CursosController extends Controller
{
    //retornar la vista de cursos.blade.php
    public function index(){
        return view('paginas.cursos');
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
        $instructores = Instructor::all(); //select * from instructor
        //select name, email from instructor
        //Instructor::select('name', 'email')->get();
        return view('paginas.registrar_curso', array("instructores" => $instructores));
    }
}
