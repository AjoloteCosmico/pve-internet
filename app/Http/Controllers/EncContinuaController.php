<?php

namespace App\Http\Controllers;
use Request;
use Illuminate\Support\Arr;
use App\Models\RespuestasContinua;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\Egresado;
use App\Models\RegistroPVEAJU;
use App\Models\MapeoCarrera;
use App\Models\Reactivo;
use App\Models\Opcion;
use App\Models\Comentario;

use App\Models\multiple_option_answer;
use DB;
class EncContinuaController extends Controller
{
    public function inicio(){
        return view('encuesta_ed_continua.inicio');
    }

public function verify(Request $request){
        
        $cuenta=Request::get('cuenta');
        $cuenta = ltrim($cuenta, "0"); 
        $cuenta_formateada= str_pad($cuenta, 9, '0', STR_PAD_LEFT);
        $Egresado=Egresado::where('cuenta',$cuenta)->first();
        //TODO: CREAR TABLA CON LOS CAMPOS NESCESARIOS ASI COMO EL MODELO
        $Encuesta=RespuestasContinua::where('cuenta',$cuenta)->first();
        if(!$Egresado){
            //si no lo encontró, lo busca con el 0
            $Egresado=Egresado::where('cuenta',$cuenta_formateada)->first();
        }
        //HAY EGRESADO
        if(!$Egresado){
            //try to find in view registro pveaju base humberto
            $EgresadoRegistro=Egresado::where('cuenta',$cuenta_formateada)->first();
            if(!$EgresadoRegistro){
            $Egresado = new Egresado();
            $Egresado->cuenta = $cuenta;
            $Egresado->fuente = 'encuesta ed continua';
            $Egresado->nombre = Request::get('nombre');
            $Egresado->paterno = Request::get('paterno');
            $Egresado->materno = Request::get('materno');
            $Egresado->save();
          }else{
            $Egresado = new Egresado();
            $Egresado->cuenta = $cuenta;
            $Egresado->fuente = 'registro ced';
            $Egresado->nombre =  $EgresadoRegistro->nombre;
            $Egresado->paterno = $EgresadoRegistro->primer_apellido;
            $Egresado->materno = $EgresadoRegistro->segundo_apellido;
            $Egresado->generacion=$EgresadoRegistro->acad_inicio;
            $Egresado->anio_egreso=$EgresadoRegistro->acad_fin;
            // $mapCarrera=mapeoCarrera::where('car_carrer',$EgresadoRegistro->car_carrer)->where('car_nivel','L')->first()
            $Egresado->save();
          } }

        if(!$Encuesta){
                $Encuesta=new RespuestasContinua();
                $Encuesta->cuenta=$cuenta;
                $Encuesta->nombre=$Egresado->nombre;
                $Encuesta->paterno=$Egresado->paterno;
                $Encuesta->materno=$Egresado->materno;
                $Encuesta->nbr2=$Egresado->carrera;
                $Encuesta->nbr3=$Egresado->plantel;
                $Encuesta->save();
            }    
        return redirect()->route('enc_continua.section',['ed_continua',$Encuesta->registro]);          
    }

    public function section($section,$id){
        $Encuesta=RespuestasContinua::find($id);
        $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->first();
       if(!$Egresado){
            //si no lo encontró, lo busca con el 0
            $Egresado=Egresado::where('cuenta',str_pad($Encuesta->cuenta, 9, '0', STR_PAD_LEFT))->first();
        }
        
        if($Egresado->carrera){
        $Carrera=Carrera::where('clave_carrera',$Encuesta->nbr2)->first()->carrera;
        $Plantel=Carrera::where('clave_plantel',$Encuesta->nbr3)->first()->plantel;
        }else{
            $Carrera="No especificada";
            $Plantel="No especificado";
        }
        $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
        $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
        // dd($Egresado);
        $Generacion=$Egresado->anio_egreso;
        if($section!='personal_data'){
            $Bloqueos=DB::table('bloqueos')->join('reactivos','bloqueos.clave_reactivo','reactivos.clave')
            ->where('reactivos.section','=',$section)->get();
            // dd($Bloqueos);
            $Reactivos=Reactivo::where('section',$section)->orderBy('orden')->get();
            //Si No esta graduado
            if($Egresado->grado=='NO'){
                $Reactivos=Reactivo::where('section',$section)->whereNotIn('clave',['pbr1','pbr1otro','pbr2','pbr3','pbr4'])->orderBy('orden')->get();
            }else{
                //GRADUADO DE DOCTORADO
                if(str_contains($Egresado->plan, 'DOCTORADO')){
                    $Reactivos=Reactivo::where('section',$section)->whereNotIn('clave',['pbr5','pbr5otro','pbr6','pbr7'])->orderBy('orden')->get();
               //GRADUADO DE MAESTRIA
                }else{
                    $Reactivos=Reactivo::where('section',$section)->whereNotIn('clave',['pbr3','pbr4','pbr5','pbr5otro','pbr6','pbr7'])->orderBy('orden')->get();
                }
            }
        }else{
            $Reactivos="";
            $Bloqueos="";
        }
        
        return view('encuesta_ed_continua.section',
                     compact('Encuesta','Egresado','Carrera','Plantel',
                            'Telefonos','Correos','section','Reactivos',
                            'Bloqueos','Generacion'));
    }

    public function update(Request $request,$id){
      
        $filteredArray = Arr::where(Request::except(['_token', '_method','btnradio','section']), function ($value, $key) {
            return $value != "on";
        });

        //  dd($filteredArray);
        $Encuesta=RespuestasContinua::find($id);
        $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->where('carrera',$Encuesta->nbr2)->first();
        $Encuesta->update($filteredArray);
        $Encuesta->save();
        $reativos_multiples=Reactivo::where('type','multiple_option')->where('section','ed_continua')->get();
        
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

        //return personal data update with mesage
        return redirect()->route('enc_continua.section',['personal_data',$Encuesta->registro]);
            // return view('encuesta2016.terminar',compact('Encuesta'));
        }

    public function update_personal_data(Request $request,$id){
        $Encuesta=RespuestasContinua::find($id);
        $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->first();
        // dd($Egresado,$Encuesta);
        $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
        $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
        
        
        foreach (Request::get('correos') as $correo) {
         if($correo!="" && $Correos->where('correo',$correo)->count()==0){
            $Correo= new Correo();
            $Correo->cuenta=$Encuesta->cuenta;
            $Correo->correo=$correo;
            $Correo->status=13;
            $Correo->save();
         }
        }

        foreach (Request::get('telefonos') as $telefono) {
            if($telefono!="" && $Telefonos->where('telefono',$telefono)->count()==0){
               $Telefono= new Telefono();
               $Telefono->cuenta=$Encuesta->cuenta;
               $Telefono->telefono=$telefono;
               $Telefono->status=13;    
               $Telefono->save();
            }
           }
          
      return redirect()->route('enc_continua.inicio')->with('message','realized');
    }
}
