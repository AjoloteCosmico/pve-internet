<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use App\Models\RespuestasContinua;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\Egresado;
use App\Models\EgresadoPos;
use App\Models\RegistroPVEAJU;
use App\Models\mapeoCarrera;
use App\Models\Reactivo;
use App\Models\Opcion;
use App\Models\Comentario;

use App\Models\multiple_option_answer;
use DB;
use Illuminate\Http\Request;

class EncuestaCredController extends Controller
{
     public function section($section){
        // $Encuesta=RespuestasVerdes::find($id);
        
        // $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->whereIn('anio_egreso',[2022,2023,2024])->first();
        // $Carrera=Carrera::where('clave_carrera',$Encuesta->nbr2)->first()->carrera;
        // $Plantel=Carrera::where('clave_plantel',$Encuesta->nbr3)->first()->plantel;
        // $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
        // $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
       
        if($section!='personal_data'){
            $Bloqueos=DB::table('bloqueos')->join('reactivos','bloqueos.clave_reactivo','reactivos.clave')
            ->where('reactivos.section','=',$section)->get();
            // dd($Bloqueos);
            $Reactivos=Reactivo::where('section',$section)->orderBy('orden')->get();
         
        }else{
            $Reactivos="";
            $Bloqueos="";
        }
        
        return view('encuesta_credencial.section',
                     compact(
                        // 'Encuesta','Egresado','Carrera','Plantel',
                        //     'Telefonos','Correos',
                            'section','Reactivos',
                            'Bloqueos'));
    }
}
