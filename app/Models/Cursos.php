<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cursos extends Model
{
    //colocamos el nombre de la tabla de la bd
    protected $table = 'courses';

    //update_at => fecha de actualizacion del registro
    //created_at => fecha de registro

    //validamos que esos 2 campos no estan en la table
    public $timestamps = false;
}
