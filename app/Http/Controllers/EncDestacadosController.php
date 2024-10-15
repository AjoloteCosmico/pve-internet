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
    public function index($cuenta){


        $key='"E"Y\x03"';
        $plaintext = "308106325";
        $cipher = "aes-128-gcm";
        if (in_array($cipher, openssl_get_cipher_methods()))
        {
            $ivlen = openssl_cipher_iv_length($cipher);
            $iv = openssl_random_pseudo_bytes($ivlen);
            $ciphertext = openssl_encrypt($plaintext, $cipher, $key, $options=0, $iv, $tag);
            echo $ciphertext."\n";
            //store $cipher, $iv, and $tag for decryption later
            $original_plaintext = openssl_decrypt($ciphertext, $cipher, $key, $options=0, $iv, $tag);
            echo $original_plaintext."\n";
        }
        $Egresado=Egresado::where('cuenta',$cuenta)->first();
        if($Egresado){
            $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
            $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
           
        }else{
            $Telefonos=null;       
            $Correos=null;       
           
        }
        return view('encuesta_destacados.encuesta',compact('cuenta','Telefonos','Correos','Egresado'));
    }

    public function save(Request $request){
        $rules=[];
        //validate rules
        $respuestas=new Destacado();


    }
}
