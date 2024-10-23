<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Destacado;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\Egresado;
use DB;
class EncDestacadosController extends Controller
{
    public function index($id){
        $dictEncrypt=Array(0=>'qw',
        1=>'bv',
        2=>'er',
        3=>'tr',
        4=>'xz',
        5=>'lo',
        6=>'rt',
        7=>'yj',
        8=>'lp',
        9=>'zx');
        $Crypted=(String)$id;
        $Decrypt='';
        for($i=0;$i<strlen($Crypted)/2;$i++) {
            echo "\n";
            echo $i*2, $i*2+2;
            echo substr($Crypted, $i*2, 2);
            $Decrypt=$Decrypt.(String)array_search(substr($Crypted, $i*2, 2),$dictEncrypt);
        }
        $Egresado=Egresado::find((int)$Decrypt);
        if($Egresado){
            $cuenta=$Egresado->cuenta;
            $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
            $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
           
        }else{
            $Telefonos=null;       
            $Correos=null;       
           
        }
        return view('encuesta_destacados.encuesta',compact('cuenta','Telefonos','Correos','Egresado'));
    }

    public function save(Request $request){
        $rules=[
            'eg1' => ['required', 'max:255'],
            'reason1' => ['required','max:255'],
            
            'eg2' => ['required', 'max:255'],
            'reason2' => ['required','max:255'],
            
            'cuenta' => ['required','max:10'],
        ];
        //validate rules
        $request->validate($rules);
        $respuestas=new Destacado();
        $Egresado=Egresado::find($request->Eg_id)->first();
        $respuestas->cuenta=$Egresado->cuenta;
        $respuestas->eg1=$request->eg1;
        $respuestas->eg2=$request->eg2;
        $respuestas->reason1=$request->reason1;
        $respuestas->reason2=$request->reason2;
        $respuestas->save();         
        


        foreach (Request::get('correos') as $correo) {
            if($correo!="" && $Correos->where('correo',$correo)->count()==0){
               $Correo= new Correo();
               $Correo->cuenta=$Encuesta->cuenta;
               $Correo->correo=$correo;
               $Correo->status='en uso';
               $Correo->save();
            }
           }
   
           foreach (Request::get('telefonos') as $telefono) {
               if($telefono!="" && $Telefonos->where('telefono',$telefono)->count()==0){
                  $Telefono= new Telefono();
                  $Telefono->cuenta=$Encuesta->cuenta;
                  $Telefono->telefono=$telefono;
                  $Telefono->status='en uso';
                  $Telefono->save();
               }
              }

    }
}
