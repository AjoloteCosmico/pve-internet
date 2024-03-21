<?php

namespace App\Http\Controllers;
use App\Models\Egresado;
use App\Models\Carrera;
use App\Models\Correo;
use Illuminate\Http\Request;

class CorreosController extends Controller
{
    public function create($cuenta,$carrera){
        $Egresado=Egresado::where('cuenta',$cuenta)->where('carrera',$carrera)->first();
         
        return view('encuesta.seg20.create_correo',compact('Egresado'));
    }
    public function store(Request $request ,$cuenta,$carrera){
        $Egresado=Egresado::where('cuenta',$cuenta)->where('carrera',$carrera)->first();
        $Correo=new Correo();
        $Correo->cuenta=$cuenta;
        $Correo->correo=$request->correo;
        $Correo->status='en uso';
        $Correo->enviado=0;
        $Correo->save();
        return redirect()->route('encuesta20.act_data',[$Egresado->cuenta,$Egresado->carrera]);
    }
}
