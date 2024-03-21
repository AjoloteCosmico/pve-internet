<?php

namespace App\Http\Controllers;
use Request;

use App\Models\respuestas20;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\Egresado;
use App\Models\Reactivo;
use App\Models\Opcion;
use App\Models\Comentario;
use DB;
class Enc20Controller extends Controller
{
    public function inicio(){
        return view('encuesta2020.inicio');
    }

    public function verify(Request $request){
        
        $cuenta=Request::get('cuenta');
        $Egresado=Egresado::where('cuenta',$cuenta)->first();
        $Encuesta=respuestas20::where('cuenta',$cuenta)->first();
        // dd($Egresado,$Encuesta);
        if(!$Egresado){
         return redirect()->route('enc20.inicio')->with('message','no_data');
        }else{
        if($Egresado->anio_egreso==2020)
        if(!$Encuesta){
            $Encuesta=new respuestas20();
            $Encuesta->cuenta=$cuenta;
            $Encuesta->nombre=$Egresado->nombre;
            $Encuesta->paterno=$Egresado->paterno;
            $Encuesta->materno=$Egresado->materno;
            $Encuesta->nombre=$Egresado->nombre;
            $Encuesta->nombre=$Egresado->nombre;
            $Encuesta->nbr2=$carrera;
            $Encuesta->nbr3=$Egresado->plantel;
            $Encuesta->gen_dgae=2020;
            $Encuesta->completed=0;
            $Encuesta->save();
        }
        if($Encuesta->completed!=1){
        return redirect()->route('enc20.section',[$Encuesta->registro,'personal_data']);}
        else{
            return redirect()->route('enc20.inicio')->with('message','realized');
        
        }
        }
    }

    public function section($id,$section){
        $Encuesta=respuestas20::find($id);
        $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->where('carrera',$Encuesta->nbr2)->first();
        $Carrera=Carrera::where('clave_carrera','=',$Egresado->carrera)->first()->carrera;
        $Plantel=Carrera::where('clave_plantel','=',$Egresado->plantel)->first()->plantel;
        $Comentario=''.Comentario::where('cuenta','=',$Encuesta->cuenta)->first();
        $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
        $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
       
        $Coment=Comentario::where('cuenta','=',$Encuesta->cuenta)->first();
        if($section!='personal_data'){
            $Bloqueos=DB::table('bloqueos')->join('reactivos','bloqueos.clave_reactivo','reactivos.clave')
            ->where('reactivos.section','=',$section)->get();
            $Reactivos=Reactivo::where('section',$section)->orderBy('order')->get();
        }else{
            $Reactivos="";
            $Bloqueos="";
        }
        return view('encuesta2020.section',compact('Encuesta','Carrera','Plantel','Egresado','Telefonos','Correos','section','Reactivos','Bloqueos'));
    }

    public function update_personal_data(Request $request,$id){
        $Encuesta=respuestas20::find($id);
        $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->where('carrera',$Encuesta->nbr2)->first();
        $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
        $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
       
        foreach (Request::get('correos') as $correo) {
         if($correo!="" && $Correos->where('correo',$correo)->count()==0){
            $Correo= new Correo();
            $Correo->cuenta=$Egresado->cuenta;
            $Correo->correo=$correo;
            $Correo->status='en uso';
            $Correo->save();
         }
        }

        foreach (Request::get('telefonos') as $telefono) {
            if($telefono!="" && $Telefonos->where('telefono',$telefono)->count()==0){
               $Telefono= new Telefono();
               $Telefono->cuenta=$Egresado->cuenta;
               $Telefono->telefono=$telefono;
               $Telefono->status='en uso';
               $Telefono->save();
            }
           }
      return redirect()->route('enc20.section',[$Encuesta->registro,'A']);
    }

    public function update(Request $request,$id){
        $Encuesta=respuestas20::find($id);
        $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->where('carrera',$Encuesta->nbr2)->first();
        $Encuesta->update(Request::except(['_token', '_method','btnradio','section']) );
        $Encuesta->save();
        $section=Request::get('section');
        
        foreach(array('A','E','F','C','D','G') as $sec){
            $format_field='sec_'.strtolower($sec);
           
            if($Encuesta->$format_field!=1){ 
                $section=$sec;
                break;
            }
        }
        if(($Encuesta->sec_a==1)&&($Encuesta->sec_a==1)&&($Encuesta->sec_c==1)&&($Encuesta->sec_d==1)&&($Encuesta->sec_e==1)&&($Encuesta->sec_f==1)&&($Encuesta->sec_g==1)){
            $Encuesta->completed=1;
            $Egresado->status=2; //i.e encuestado via Internet
       
        }else{
            $Encuesta->completed=0;
            $Egresado->status=10; //encuesta inconclusa
        }
        $Encuesta->save();
        $Egresado->save();
        if($Encuesta->completed==1){
           return view('encuesta2020.terminar');
        }else{

        }
        return redirect()->route('enc20.section',[$Encuesta->registro,$section]);
        // dd(Request::all());
    }
}
