<?php

namespace App\Http\Controllers;
use Request;
use Illuminate\Support\Arr;
use App\Models\RespuestasEspecialidad;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\EgresadosEsp;
use App\Models\Reactivo;
use App\Models\Opcion;
use App\Models\multiple_option_answer;
use App\Models\Comentario;
use DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Hash;
class EncContinuaEspecialidad extends Controller
{
    //
    public function inicio(){
        return view('encuesta_especialidad.inicio');
    }


    public function verify(Request $request){
        
        $cuenta=Request::get('cuenta');
        $cuenta = ltrim($cuenta, "0");
        $Egresado=EgresadosEsp::where('cuenta',$cuenta)->first();
        //TODO: CREAR TABLA CON LOS CAMPOS NESCESARIOS ASI COMO EL MODELO
        $Encuesta=RespuestasEspecialidad::where('cuenta',$cuenta)->first();
        //HAY EGRESADO
        if($Egresado){
            //LLENA LOS DATOS CON LA TABLA DE EG Y COMIENZA ENC
            if(!$Encuesta){
                $Encuesta=new RespuestasEspecialidad();
                $Encuesta->cuenta=$cuenta;
                $Encuesta->nombre=$Egresado->nombre;
                $Encuesta->paterno=$Egresado->paterno;
                $Encuesta->materno=$Egresado->materno;
                $Encuesta->especialidad=$Egresado->especialidad;
                $Encuesta->plantel=$Egresado->plantel;
             
                $Encuesta->completed=0;
                $Encuesta->save();
                //Revisar si pertenece a maestria o doctorado

                //revisar si ya esta graduado
            }
             //comnzar encuesta especialidad
            if($Encuesta->completed!=1){
              return redirect()->route('enc_esp.section',[$Encuesta->registro,'personal_data']);
            }
            else{
                return redirect()->route('enc_esp.inicio')->with('message','realized');
            }
        }
         else{
            //NO ESSTA EN LA MIUESTRA DE ESPECIALIDAD
            return redirect()->route('enc_esp.inicio')->with('message','notinsample');
            }              
    }

 public function section($id,$section){
        $Encuesta=RespuestasEspecialidad::find($id);
        $Egresado=EgresadosEsp::where('cuenta',$Encuesta->cuenta)->first();
        
       $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
       $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
       
        if($section!='personal_data'){
            $Bloqueos=DB::table('bloqueos')->join('reactivos','bloqueos.clave_reactivo','reactivos.clave')
            ->where('reactivos.section','=',$section)->get();
            // dd($Bloqueos);
            $Reactivos=Reactivo::where('section',$section)->orderBy('orden')->get();
            //Si No esta graduado    
           
        }else{
            $Reactivos="";
            $Bloqueos="";
        }
        $NombreSeccion="";
        switch ($section) {
            case 'espA':
                $NombreSeccion="SECCIÓN 1: Perfil del egresado";
                break;
            case 'espB':
                $NombreSeccion="SECCIÓN 2: Datos académicos";
                break;
            case 'espC':
                $NombreSeccion="SECCIÓN 3: Situación laboral";
                break;
            case 'espD':
                $NombreSeccion="SECCIÓN 4: Satisfacción con la especialidad";
                break;       
        }
        return view('encuesta_especialidad.section',
                     compact('Encuesta','Egresado',
                            'Telefonos','Correos','section','Reactivos',
                            'Bloqueos','NombreSeccion'));
    }
    

    public function update_personal_data(Request $request,$id){
        $Encuesta=RespuestasEspecialidad::find($id);
        $Egresado=EgresadosEsp::where('cuenta',$Encuesta->cuenta)->first();
        // dd($Egresado,$Encuesta);
        $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
        $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
        // if($Egresado->fuente=='internet'){

        //    $Egresado->plan=Request::get('plan');
        //    $Egresado->programa=Request::get('programa');
        //    $Egresado->grado=Request::get('grado');
        //    $Egresado->anio_egreso=Request::get('anio');
        //    $Egresado->save();
           
        //    if(Request::get('plan')=="" || Request::get('programa')==""|| Request::get('grado')=="" || Request::get('anio')==""){
        //     return redirect()->back()
        //     ->with('message','incomplete_data');
        //    }
        
        // if(Request::get('grado')=='NO'){
        //     $Encuesta->sec_pb='1';
        //     $Encuesta->save();
        // }
        // }

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
           $section='espA';
        
           foreach(array('espA','espB','espC','espD') as $sec){
               $format_field='sec_'.strtolower($sec);
              
               if($Encuesta->$format_field!=1){ 
                   $section=$sec;
                   break;
               }
           }
      return redirect()->route('enc_esp.section',[$Encuesta->registro,$section]);
    }

    public function update(Request $request,$id){
        
        $filteredArray = Arr::where(Request::except(['_token', '_method','btnradio','section']), function ($value, $key) {
            return $value != "on";
        });

        $Encuesta=RespuestasEspecialidad::find($id);
        $Egresado=EgresadosEsp::where('cuenta',$Encuesta->cuenta)->first();
        $Encuesta->update($filteredArray);
        $Encuesta->save();
        // dd(Request::all(),$filteredArray);
        $section=Request::get('section');
        
        //si la seccion contiene reactivos multiples,  iteramos sobre ellos
        $reativos_multiples=Reactivo::where('type','multiple_option')->where('section',$section)->get();
        foreach($reativos_multiples as $r){
            $clave=$r->clave;
            $selected_options = Arr::where(Request::except(['_token', '_method','btnradio','section']), function ($value, $key) use($clave){
                return str_contains($key,$clave.'opcion');
            });
            // dd($selected_options);
            //borramos las respuestas seleccionadas anteriores (si las habia)
            $affectedRows = multiple_option_answer::where('encuesta_id',$Encuesta->registro)
               ->where('reactivo',$clave)->delete();
            foreach($selected_options as $key => $value){
                $answer=new multiple_option_answer();
                $answer->encuesta_id=$Encuesta->registro;
                $answer->reactivo=$clave;
                $answer->clave_opcion=str_replace($clave.'opcion','',$key);
                $answer->save();
            }
            // dd($selected_options);
        }


        foreach(array('espA','espB','espC','espD') as $sec){
            $format_field='sec_'.strtolower($sec);
           
            if($Encuesta->$format_field!=1){ 
                $section=$sec;
                break;
            }
        }
        if(($Encuesta->sec_espa==1)&&($Encuesta->sec_espb==1)&&($Encuesta->sec_espc==1)&&($Encuesta->sec_espd==1)){
            $Encuesta->completed=1;
            $Encuesta->aplica=111;
            $Encuesta->fec_capt=now()->modify('-6 hours') ;
            $Egresado->status=2; //i.e encuestado via Internet

        }else{
            $Encuesta->completed=0;
            $Egresado->status=10; //encuesta inconclusa
        }
        $Encuesta->save();
        $Egresado->save();
        if($Encuesta->completed==1){
            $qrString='esp'.$Egresado->cuenta.' '.$Encuesta->registro.'_'.now()->format('Ymd');
            $qrCode = QrCode::size(200)
                       ->color(5,10,48)
                       ->style('round')
                    //    ->format('png')
                       ->merge('\public\img\logos\logoPVE-large.png',0.3,)
                       ->generate($qrString);
           
           return view('encuesta_especialidad.terminar',compact('Encuesta','qrCode'));
        }else{

        }
        return redirect()->route('enc_esp.section',[$Encuesta->registro,$section]);
        // dd(Request::all());
    }

    public function showQrCode($surveyId)
    {
        // 1. Obtener los datos necesarios de la encuesta
        $survey = \App\Models\Survey::findOrFail($surveyId);

        // 2. Definir la cadena de texto para el QR
        // Concatena el ID y la fecha de aplicación (ejemplo: '2025-12-05')
        $dataToEncode = $survey->id . '_' . $survey->application_date->format('Ymd');
        
        // 3. Opcional: Hashear la cadena para mayor seguridad si es lo que deseas verificar despues
        // Si quieres usar el hash como la clave, codifica el hash
        $hashedData = Hash::make($dataToEncode);
        
        // La cadena final que se codificará en el QR
        $qrString = $hashedData; 

        // 4. Generar el QR
        $qrCode = QrCode::size(200)->generate($qrString);

        return view('survey.qrcode', compact('qrCode', 'survey'));
    }
}
