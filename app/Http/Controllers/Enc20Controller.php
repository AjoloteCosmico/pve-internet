<?php

namespace App\Http\Controllers;
use Request;
use Illuminate\Support\Arr;
use App\Models\respuestas20;
use App\Models\respuestas16;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\Egresado;
use App\Models\Reactivo;
use App\Models\Opcion;
use App\Models\multiple_option_answer;
use App\Models\Comentario;
use DB;

class Enc20Controller extends Controller
{
    public function inicio($type){
        if($type== '2016'){
            return redirect()->route('enc16.inicio','general');
        }
        return view('encuesta2020.inicio',compact('type'));
    }

    public function verify(Request $request){

        $cuenta=Request::get('cuenta');
        $Egresado=Egresado::where('cuenta',$cuenta)->first();
        $Encuesta=respuestas20::where('cuenta',$cuenta)->first();
        //HAY EGRESADO
        if($Egresado){
          //ES 2020
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


          }
          //ES 2016
          if($Egresado->anio_egreso==2016 && $Egresado->act_suvery==1){
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
        }else{
          //NO ES 2020
            if(Request::get('type')=='general'){
                 //TYPE=GENERAL
                //SE LLENAN LOS DATOS CON EL INPUT Y COMIENZA ENC
                
                if(!$Encuesta){
                    $Encuesta=new respuestas20();
                    $Encuesta->cuenta=$cuenta;
                    $Encuesta->aplica2=1;
                    $Encuesta->nombre=Request::get('nombre');
                    $Encuesta->paterno=Request::get('paterno');
                    $Encuesta->materno=Request::get('materno');
                    $Encuesta->completed=0;
                    $Encuesta->save();
                }
                if($Encuesta->completed!=1){
                    return redirect()->route('enc20.section',[$Encuesta->registro,'personal_data']);}
                    else{
                        return redirect()->route('enc.inicio','2020')->with('message','realized');
                    
                    }
            }
          
            if(Request::get('type')=='2020'){
            //TYPE 2020
                //REDIRECCIONA A ENC GENERAL
                return redirect()->route('enc.inicio','general')->with('message','notinsample');
          }
              
          
                }
            }else{
                   //NO HAY ERGESADO
                   if(Request::get('type')=='general'){
                    //TYPE=GENERAL
                    $Egresado=new Egresado();
                $Egresado->cuenta=$cuenta;
                $Egresado->fuente='encuesta externa';
                $Egresado->nombre=Request::get('nombre');
                $Egresado->paterno=Request::get('paterno');
                $Egresado->materno=Request::get('materno');
                $Egresado->save();
                    if(!$Encuesta){
                        $Encuesta=new respuestas20();
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
                        return redirect()->route('enc20.section',[$Encuesta->registro,'personal_data']);}
                        else{
                            return redirect()->route('enc.inicio','general')->with('message','realized');
                        
                        }
                }
               if(Request::get('type')=='2020'){
                    //TYPE 2020
                   //REDIRECCIONA A ENC GENERAL
                   return redirect()->route('enc.inicio','general')->with('message','notinsample');;
               }
               
             }      
    }



    public function section($id,$section){
        $Encuesta=respuestas20::find($id);
        $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->where('carrera',$Encuesta->nbr2)->first();
        $Carrera=" ";
        $Plantel=" ";
        if($Encuesta->aplica2==1){
            $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->first();
            // enviar la lista de planteles
            $Planteles=Carrera::select('clave_plantel','plantel')->distinct()->get();
           
            $Carreras=Carrera::all();
            if($Encuesta->nbr2){
                $Carrera=Carrera::where('clave_carrera','=',$Encuesta->nbr2)->first()->carrera;
                $Plantel=Carrera::where('clave_plantel','=',$Encuesta->nbr3)->first()->plantel;
            
            }
             
        }else{
            $Carrera=Carrera::where('clave_carrera','=',$Egresado->carrera)->first()->carrera;
            $Plantel=Carrera::where('clave_plantel','=',$Egresado->plantel)->first()->plantel;
            $Planteles=' ';
            $Carreras=' ';
        }
        
        $Comentario=''.Comentario::where('cuenta','=',$Encuesta->cuenta)->first();
        $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
        $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
       
        $Coment=Comentario::where('cuenta','=',$Encuesta->cuenta)->first();
        if($section!='personal_data'){
            $Bloqueos=DB::table('bloqueos')->join('reactivos','bloqueos.clave_reactivo','reactivos.clave')
            ->where('reactivos.section','=',$section)
            // ->where('bloqueos.bloqueado','like','n'.strtolower($section).'%')
            ->get();
            $Reactivos=Reactivo::where('section',$section)->orderBy('orden')->get();
            
            $Bloqueos=$Bloqueos->whereIn('bloqueado',$Reactivos->unique('clave')->pluck('clave')->toArray());
        }else{
            $Reactivos="";
            $Bloqueos="";
        }
        $NombreSeccion="";
        switch ($section) {
            case 'A':
                $NombreSeccion="SECCIÓN 1: Datos sociodemográficos";
                break;
            case 'E':
                $NombreSeccion="SECCIÓN 2: Actualización académica";
                break;
            case 'C':
                $NombreSeccion="SECCIÓN 4: Datos laborales";
                break;
            case 'D':
                $NombreSeccion="SECCIÓN 5: Incorporación al mercado";
                break; 
            case 'F':
                $NombreSeccion="SECCIÓN 3: Satisfacción con la institución";
                break;
            case 'G':
                $NombreSeccion="SECCIÓN 6: Habilidades desarrolladas";
                break;            
        }
        return view('encuesta2020.section',
                     compact('Encuesta','Carrera','Plantel','Egresado',
                            'Telefonos','Correos','section','Reactivos',
                            'Bloqueos','NombreSeccion','Planteles','Carreras'));
    }

    public function update_personal_data(Request $request,$id){
        $Encuesta=respuestas20::find($id);
        $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->first();
        // dd($Egresado,$Encuesta);
        $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
        $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
        
        if($Encuesta->aplica2==1){
            $Encuesta->nbr2=Request::get('nbr2');
            $Encuesta->nbr3=Request::get('nbr3');
            $Encuesta->save();
            $Egresado->plantel=Request::get('nbr3');
            $Egresado->carrera=Request::get('nbr2');
            $Egresado->anio_egreso=Request::get('anio_egreso');
            $Egresado->save();
        }
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
           $section='A';
        
           foreach(array('A','E','F','C','D','G') as $sec){
               $format_field='sec_'.strtolower($sec);
              
               if($Encuesta->$format_field!=1){ 
                   $section=$sec;
                   break;
               }
           }
      return redirect()->route('enc20.section',[$Encuesta->registro,$section]);
    }

    public function update(Request $request,$id){
        
        $filteredArray = Arr::where(Request::except(['_token', '_method','btnradio','section']), function ($value, $key) {
            return $value != "on";
        });
        // dd(Request::all(),$filteredArray);
        $Encuesta=respuestas20::find($id);
        $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->where('carrera',$Encuesta->nbr2)->first();
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


        foreach(array('A','E','F','C','D','G') as $sec){
            $format_field='sec_'.strtolower($sec);
           
            if($Encuesta->$format_field!=1){ 
                $section=$sec;
                break;
            }
        }
        if(($Encuesta->sec_a==1)&&($Encuesta->sec_a==1)&&($Encuesta->sec_c==1)&&($Encuesta->sec_d==1)&&($Encuesta->sec_e==1)&&($Encuesta->sec_f==1)&&($Encuesta->sec_g==1)){
            $Encuesta->completed=1;
            $Encuesta->aplica=111;
            $Encuesta->ncr21_a=$Encuesta->ncr21;
            $Encuesta->fec_capt=now()->modify('-6 hours') ;
            $Egresado->status=2; //i.e encuestado via Internet

        }else{
            $Encuesta->completed=0;
            $Egresado->status=10; //encuesta inconclusa
        }
        $Encuesta->save();
        $Egresado->save();
        if($Encuesta->completed==1){
           return view('encuesta2020.terminar',compact('Encuesta'));
        }else{

        }
        return redirect()->route('enc20.section',[$Encuesta->registro,$section]);
        // dd(Request::all());
    }
}
