<?php

namespace App\Http\Controllers;
use Request;
use Illuminate\Support\Arr;
use App\Models\respuestas16;
use App\Models\respuestas20;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\Egresado;
use App\Models\Reactivo;
use App\Models\Opcion;
use App\Models\multiple_option_answer;
use App\Models\Comentario;
use DB;

class Enc16Controller extends Controller
{
    public function inicio($type){
        return view('encuesta2016.inicio',compact('type'));
    }

    public function verify(Request $request){

        $cuenta=Request::get('cuenta');
        $Egresado=Egresado::where('cuenta',$cuenta)->first();
        $Encuesta=respuestas16::where('cuenta',$cuenta)->first();
        //hay egresado
        if($Egresado){
            //es 2016
            if($Egresado->anio_egreso==2016&&$Egresado->act_suvery==1){
                //llena los datos de la tabla y comienza la encuesta
                if(!$Encuesta){
                    $Encuesta=new respuestas16();
                    $Encuesta->cuenta=$cuenta;
                    $Encuesta->nombre=$Egresado->nombre;
                    $Encuesta->paterno=$Egresado->paterno;
                    $Encuesta->materno=$Egresado->materno;
                    $Encuesta->nbr2=$Egresado->carrera;
                    $Encuesta->nbr3=$Egresado->plantel;
                    $Encuesta->completed=0;
                    $Encuesta->save();
                }
                //Comenzar encuesta 2016
                if($Encuesta->completed!=1){
                    return redirect()->route('enc16.section',[$Encuesta->registro,'personal_data']);}
                    else{
                        return redirect()->route('enc16.inicio','2016')->with('message','realized');
                    }
            }
            //si es 2020
            if($Egresado->anio_egreso==2020||$Egresado->muestra==3){
                //LLENA LOS DATOS CON LA TABLA DE EG Y COMIENZA ENC
                if(!$Encuesta){
                    $Encuesta=new respuestas20();
                    $Encuesta->cuenta=$cuenta;
                    $Encuesta->nombre=$Egresado->nombre;
                    $Encuesta->paterno=$Egresado->paterno;
                    $Encuesta->materno=$Egresado->materno;
                    $Encuesta->nbr2=$Egresado->carrera;
                    $Encuesta->nbr3=$Egresado->plantel;
                    $Encuesta->gen_dgae=2020;
                    $Encuesta->completed=0;
                    $Encuesta->save();
                }
                 //comnzar encuesta 2020
                if($Encuesta->completed!=1){
                return redirect()->route('enc20.section',[$Encuesta->registro,'personal_data']);}
                else{
                    return redirect()->route('enc.inicio','2020')->with('message','realized');
                
                }
    
    
            }else{
                //no es 2016 ni 2020
                if(Request::get('type')=='general'){
                    //se registran los datos e inicia la encuesta

                    if(!$Encuesta){
                        $Encuesta=new respuestas16();
                        $Encuesta->cuenta=$cuenta;
                        $Encuesta->aplica2=1;
                        $Encuesta->nombre=Request::get('nombre');
                        $Encuesta->paterno=Request::get('paterno');
                        $Encuesta->materno=Request::get('materno');
                        $Encuesta->completed=0;
                        $Encuesta->save();
                    }
                    if($Encuesta->completed!=1){
                        return redirect()->route('enc16.section',[$Encuesta->registro,'personal_data']);
                    }else{
                        return redirect()->route('enc16.inicio', '2016')->with('message','realized');
                    }
                }

                if(Request::get('type')=='2016'){
                    //type 2016
                    //redirecciona a encuesta general
                    return redirect()->route('enc16.inicio', 'general')->with('message','notinsample');
                }
            }
        }else{
            //No hay egresado
            if(Request::get('type')=='general'){
                $Egresado->cuenta=$cuenta;
                $Egresado->fuente='encuesta externa';
                $Egresado->nombre=Request::get('nombre');
                $Egresado->paterno=Request::get('nombre');
                $Egresado->materno=Request::get('materno');
                $Egresado->save();
                    if(!$Encuesta){
                        $Encuesta=new respuestas16();
                        $Encuesta->cuenta=$cuenta;
                        $Encuesta->aplica2=1;
                        $Encuesta->nombre=Request::get('nombre');
                        $Encuesta->paterno=Request::get('paterno');
                        $Encuesta->materno=Request::get('materno');
                        $Encuesta->gen_dgae=Request::get('anio_egreso');
                        $Encuesta->completed=0;
                        $Encuesta->save();
                    }
                    if($Encuesta->completed!=1){
                        return redirect()->route('enc16.section',[$Encuesta->registro,'personal_data']);
                    }else{
                        return redirect()->route('enc16.inicio','general')->with('message','realized');
                    }

            }
            if(Request::get('type')=='2016'){
                //tipo2016 redirecciona a encuesta general
                return redirect()->route('enc16.inicio','general')->with('message','notinsample');;
            }
        }
    }















}