<?php

namespace App\Http\Controllers;
use Request;
// use Illuminate\Http\Request;

use App\Models\Destacado;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\Egresado;

use DB;
class EncDestacadosController extends Controller
{
    public function index(){
        // $dictEncrypt=Array(0=>'qw',
        // 1=>'bv',
        // 2=>'er',
        // 3=>'tr',
        // 4=>'xz',
        // 5=>'lo',
        // 6=>'rt',
        // 7=>'yj',
        // 8=>'lp',
        // 9=>'zx');
        // $Crypted=(String)$id;
        // $Decrypt='';
        // for($i=0;$i<strlen($Crypted)/2;$i++) {
        //     // echo "\n";
        //     // echo $i*2, $i*2+2;
        //     // echo substr($Crypted, $i*2, 2);
        //     $Decrypt=$Decrypt.(String)array_search(substr($Crypted, $i*2, 2),$dictEncrypt);
        // }
        // //Identificar si ha entrado a la pagina
        // $Egresado=Egresado::find((int)$Decrypt);
        // $Egresado->enc_destacados=$Egresado->enc_destacados+1;
        // $Egresado->save();
        // if($Egresado){
        //     $cuenta=$Egresado->cuenta;
        //     $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
        //     $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
           
        // }else{
        //     $Telefonos=null;       
        //     $Correos=null;       
           
        // }
        return view('encuesta_destacados.encuesta'
        // ,compact('cuenta','Telefonos','Correos','Egresado')
        );
    }

    public function save(Request $request){
        $rules=[
            'eg1' => 'required|max:255',
            'reason1' => 'required|max:255',
            'eg2' => 'required|max:255',
            'reason2' => 'required|max:255',
            'cuenta' => 'required|max:10'];
        $messages=['eg1.required'=>'EL Nombre del egresado es necesario para la nominación',
                   'eg1.max:255'=> 'Nombre demasiado largo',
                   'reason1.required'=>'Debe ingresar almenos una razon para nominar a este egresado',
                   'reason1.max:255'=>'mucho texto',
            
            'eg2.required'=>'EL Nombre del egresado es necesario para la nominación',
            'eg2.max:255'=> 'Nombre demasiado largo',
            'reason2.required'=>'Debe ingresar almenos una razon para nominar a este egresado',
            'reason2.max:255'=>'mucho texto',
            
            'cuenta.required'=>'por favor ingrese su numero de cuenta',
            'cuenta.max:10'=>'la cuenta solo debe tener 10 caracteres'
        ];
        
        //validate rules
        Request::validate($rules,$messages);
        $respuestas=new Destacado();
        // $Egresado=Egresado::find(Request::get('Eg_id'))->first();

        // $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
        // $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
       
        $respuestas->cuenta_r=Request::get('cuenta');
        $respuestas->eg_id=0;
        $respuestas->eg1=Request::get('eg1');
        $respuestas->eg2=Request::get('eg2');
        $respuestas->reason1=Request::get('reason1');
        $respuestas->reason2=Request::get('reason2');
        $respuestas->save();         
        

        foreach (Request::get('correos') as $correo) {
            // if($correo!="" && $Correos->where('correo',$correo)->count()==0){
               $Correo= new Correo();
               $Correo->cuenta=$respuestas->cuenta_r;
               $Correo->correo=$correo;
               $Correo->status='from destacados';
               $Correo->save();
            // }
           }
   
           foreach (Request::get('telefonos') as $telefono) {
            //    if($telefono!="" && $Telefonos->where('telefono',$telefono)->count()==0){
                  $Telefono= new Telefono();
                  $Telefono->cuenta=$respuestas->cuenta_r;
                  $Telefono->telefono=$telefono;
                  $Telefono->status='from destacados';
                  $Telefono->save();
            //    }
              }
              return view('encuesta2020.terminar');
    }
    
}
