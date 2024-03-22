<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\respuestas2;
use App\Models\respuestas14;
use App\Models\Carrera;
use DB;
use App\Models\User;
use App\Models\Estudio;
use App\Models\Egresado;
use App\Models\Muestra;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

use Symfony\Component\Process\Process; 
use Symfony\Component\Process\Exception\ProcessFailedException; 
class HomeController extends Controller
{
    
    public function index()
    {
        dd('pagina principla');
           }

     
}

