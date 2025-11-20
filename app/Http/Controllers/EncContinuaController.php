<?php

namespace App\Http\Controllers;
use Request;
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
//BUSCAR EN BASE LICENCITATURA
        //si se encuentra en el registro del seguimiento licenciatura
        if(!$Egresado){
            //si no se encontró, busca con el 0
            $Egresado=Egresado::where('cuenta',$cuenta_formateada)->first();
        }
      
        //hasta aqui, revisamos si se encontro en el registro del seguimiento, si es asi llenamos carrera y año
        if($Egresado){
            $CarreraRow=Carrera::where('clave_carrera',$Egresado->carrera)->first();
            if($CarreraRow){
                $Carrera=$CarreraRow->carrera;
            }else{
                $Carrera=" ";
            }
            $AnioEgreso=$Egresado->anio_egreso;
            $cuenta_encuesta=$Egresado->cuenta;
            $Encuesta=RespuestasContinua::where('cuenta',$Egresado->cuenta)->first();
            if(!$Encuesta){
                // dd("flag lic");
                $Encuesta=new RespuestasContinua();
                $Encuesta->cuenta=$cuenta_encuesta;
                $Encuesta->nombre=$Egresado->nombre;
                $Encuesta->paterno=$Egresado->paterno;
                $Encuesta->materno=$Egresado->materno;
                $Encuesta->nbr2=$Egresado->carrera;
                $Encuesta->nbr3=$Egresado->plantel;
                $Encuesta->carrera=$Carrera;
                $Encuesta->anio_egreso=$AnioEgreso;
                $Encuesta->save();
            }    
        return redirect()->route('enc_continua.section',['ed_continua',$Encuesta->registro]); 
        }
//BUSCAR EN BASE POSGRADO         
        
        if(!$Egresado){
            //si no lo encontró, lo busca en la base de posgrado
            $Egresado=EgresadoPos::where('cuenta',$cuenta)->first();
        }
        if(!$Egresado){
            //si no lo encontró, lo busca en la base de posgrado con 0
            $Egresado=EgresadoPos::where('cuenta',$cuenta_formateada)->first();
        }

        if($Egresado){
            //caso en que el egresado esta en  la base de seguimiento posgrado
            $Carrera=$Egresado->plan;
            $AnioEgreso=$Egresado->anio_egreso;
            $cuenta_encuesta=$Egresado->cuenta;
            $Encuesta=RespuestasContinua::where('cuenta',$Egresado->cuenta)->first();
            if(!$Encuesta){
                // dd("flag pos");
                $Encuesta=new RespuestasContinua();
                $Encuesta->cuenta=$cuenta_encuesta;
                $Encuesta->nombre=$Egresado->nombre;
                $Encuesta->paterno=$Egresado->paterno;
                $Encuesta->materno=$Egresado->materno;
                $Encuesta->nbr2=0;
                $Encuesta->nbr3=0;
                $Encuesta->carrera=$Carrera;
                $Encuesta->anio_egreso=$AnioEgreso;
                $Encuesta->save();
            }    
        return redirect()->route('enc_continua.section',['ed_continua',$Encuesta->registro]); 
        }
//BUSCAR EN REGISTRO PVEAJU 
        if(!$Egresado){
            //try to find in view registro pveaju base humberto
            $Egresado=RegistroPVEAJU::where('exa_cuenta',$cuenta_formateada)->orderByDesc('acad_afin')->first();
         }
         if($Egresado){
            //caso en en que el egresado esta en la base del registro humberto
            $CarreraMap=MapeoCarrera::where('car_carrer',$Egresado->car_carrer)->first();
            

            $Carrera='';
            if($CarreraMap){
                if($CarreraMap->car_nivel=='L'){
                    // dd($CarreraMap);
                    $Carrera=Carrera::where('clave_carrera',$CarreraMap->carrera_id)->first()->carrera;
                }elseif($CarreraMap->clave_programa){
                    $Carrera='Posgrado';
                }
            }
            
            $AnioEgreso=$Egresado->acad_afin;
            $cuenta_encuesta=$Egresado->exa_cuenta;
            $Encuesta=RespuestasContinua::whereIn('cuenta',[$cuenta,$cuenta_formateada])->first();
            if(!$Encuesta){
                // dd("flag reg");
                $Encuesta=new RespuestasContinua();
                $Encuesta->cuenta=$cuenta_encuesta;
                $Encuesta->nombre=$Egresado->nombre;
                $Encuesta->paterno=$Egresado->primer_apellido;
                $Encuesta->materno=$Egresado->segundo_apellido;
                $Encuesta->nbr2=$CarreraMap->carrera_id;
                $Encuesta->nbr3=$CarreraMap->plantel_id;
                $Encuesta->carrera=$Carrera;
                $Encuesta->anio_egreso=$AnioEgreso;
                $Encuesta->save();
            }
            
            return redirect()->route('enc_continua.section',['ed_continua',$Encuesta->registro]);  
          }
//CREAR EGRESADO DIRECTAMENTE
        if(!$Egresado){
            
            $Egresado = new Egresado();
            $Egresado->cuenta = $cuenta;
            $Egresado->fuente = 'encuesta ed continua';
            $Egresado->nombre = Request::get('nombre');
            $Egresado->paterno = Request::get('paterno');
            $Egresado->materno = Request::get('materno');
            $Egresado->save();
            $cuenta_encuesta=$Egresado->cuenta;
            $Encuesta=RespuestasContinua::where('cuenta',$Egresado->cuenta)->first();
          } 





        if(!$Encuesta){
            // dd("flag ultima");
                $Encuesta=new RespuestasContinua();
                $Encuesta->cuenta=$cuenta_encuesta;
                $Encuesta->nombre=$Egresado->nombre;
                $Encuesta->paterno=$Egresado->paterno;
                $Encuesta->materno=$Egresado->materno;
                $Encuesta->nbr2=$Egresado->carrera;
                $Encuesta->nbr3=$Egresado->plantel;
                $Encuesta->carrera="";
                $Encuesta->save();
            }    
        return redirect()->route('enc_continua.section',['ed_continua',$Encuesta->registro]);          
    }

    public function section($section,$id){
        $Encuesta=RespuestasContinua::find($id);
        
        $Telefonos=Telefono::where('cuenta',$Encuesta->cuenta)->get();       
        $Correos=Correo::where('cuenta',$Encuesta->cuenta)->get();       
        if($section!='personal_data'){
            $Bloqueos=DB::table('bloqueos')->join('reactivos','bloqueos.clave_reactivo','reactivos.clave')
            ->where('reactivos.section','=',$section)->get();
            // dd($Bloqueos);
            $Reactivos=Reactivo::where('section',$section)->orderBy('orden')->get();
            
        }else{
            $Reactivos="";
            $Bloqueos="";
        }
        
        return view('encuesta_ed_continua.section',
                     compact('Encuesta',
                            'Telefonos','Correos','section','Reactivos',
                            'Bloqueos',));
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
        $Telefonos=Telefono::where('cuenta',$Encuesta->cuenta)->get();       
        $Correos=Correo::where('cuenta',$Encuesta->cuenta)->get();       
        
        
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
