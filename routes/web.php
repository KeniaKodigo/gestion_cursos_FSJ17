<?php

use App\Http\Controllers\CursosController;
use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('template');
});

//get, post, put, delete
//asignando un nombre a la ruta con el metodo name()
Route::get('/cursos',[CursosController::class, 'index'])->name('cursos');
Route::get('/formulario',[CursosController::class, 'getForm']);

//creando una nueva ruta

//post, put, delete => token
Route::post('/registro', [CursosController::class, 'store'])->name('registrarCurso');
Route::get('/editar/{id}', [CursosController::class, 'editar'])->name('editarCurso');

Route::put('/actualizar/{id}', [CursosController::class, 'update'])->name('actualizarCurso');

Route::delete('/eliminar/{id}', [CursosController::class, 'destroy'])->name('eliminarCurso');

#APARTADO DE REPORTES
Route::get('/reporte_cursos', [PDFController::class, 'listaCursos'])->name('reporte_cursos');




