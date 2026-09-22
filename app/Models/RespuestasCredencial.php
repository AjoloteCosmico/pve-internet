<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespuestasCredencial extends Model
{
    use HasFactory;
    protected $table = 'respuestas_credencial';
    protected $primaryKey = 'registro';
    protected $guarded = [];  
}
