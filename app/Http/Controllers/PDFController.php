<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cursos;
//use PDF;
use Barryvdh\DomPDF\Facade\Pdf;

class PDFController extends Controller
{
    //metodo para obtener todos los cursos, nombre, correo (instructores)
    public function listaCursos(){
        /**
         * SELECT courses.title, courses.description, courses.price, instructor.name, instructor.email FROM courses INNER JOIN instructor ON courses.id_instructor = instructor.id;
         */

        $lista = Cursos::join('instructor','courses.id_instructor', '=', 'instructor.id')->select('courses.title','courses.description','courses.price','instructor.name','instructor.email')->get();
        /**
         * loadview() => metodo donde asignamos la vista donde se va generar el reporte y su informacion
         */
        //$pdf = PDF::loadView('PDF.reporte_cursos', array("lista" => $lista));
        $pdf = PDF::loadView('PDF.reporte_cursos', compact('lista'));
        /**
         * stream() => visualiza el pdf (despues se puede descargar)
         * download() => se descarga automaticamente
         */
        return $pdf->stream('listadoCursos.pdf');
    }
}
