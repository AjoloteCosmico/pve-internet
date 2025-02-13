<?php


namespace App\Http\Controllers;
use Request;
use Illuminate\Support\Arr;
use App\Models\respuestasPosgrado;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\EgresadoPos;
use App\Models\Reactivo;
use App\Models\Opcion;
use App\Models\multiple_option_answer;
use App\Models\Comentario;
use DB;

class PosgradoController extends Controller
{
    public function inicio(){
        return view('encuestaPosgrado.inicio');
    }

    public function verify(Request $request){

        $cuenta=Request::get('cuenta');
        $Egresado=EgresadoPos::where('cuenta',$cuenta)->first();
        //TODO: CREAR TABLA CON LOS CAMPOS NESCESARIOS ASI COMO EL MODELO
        $Encuesta=respuestasPosgrado::where('cuenta',$cuenta)->first();
        //HAY EGRESADO
        if($Egresado){
            //LLENA LOS DATOS CON LA TABLA DE EG Y COMIENZA ENC
            if(!$Encuesta){
                $Encuesta=new respuestasPosgrado();
                $Encuesta->cuenta=$cuenta;
                $Encuesta->nombre=$Egresado->nombre;
                $Encuesta->paterno=$Egresado->paterno;
                $Encuesta->materno=$Egresado->materno;
                $Encuesta->nombre=$Egresado->nombre;
                $Encuesta->nombre=$Egresado->nombre;
                $Encuesta->carrera=$Egresado->carrera;
                $Encuesta->plantel=$Egresado->plantel;
             
                $Encuesta->completed=0;
                $Encuesta->save();
                //Revisar si pertenece a maestria o doctorado

                //revisar si ya esta graduado
            }
             //comnzar encuesta 2020
            if($Encuesta->completed!=1){
            return redirect()->route('enc_posgrado.section',[$Encuesta->registro,'personal_data']);}
            else{
                return redirect()->route('enc_posgrado.inicio')->with('message','realized');
            }


          }else{
          //NO ESSTA EN LA MIUESTRA DE POSGRADO
             
            //TYPE 2020
                //REDIRECCIONA A ENC GENERALs
                return redirect()->route('enc_posgrado.inicio')->with('message','notinsample');
          
              
          
                }
                   
    }

    public function section($id,$section){
        $Encuesta=respuestasPosgrado::find($id);
        $Egresado=EgresadoPos::where('cuenta',$Encuesta->cuenta)->first();
        
       $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
       $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
       
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
        $NombreSeccion="";
        switch ($section) {
            case 'pA':
                $NombreSeccion="SECCIÓN 1: Datos sociodemográficos";
                break;
            case 'pB':
                $NombreSeccion="SECCIÓN 2: Obtención del grado";
                break;
            case 'pC':
                $NombreSeccion="SECCIÓN 3: Actualización académica";
                break;
            case 'pD':
                $NombreSeccion="SECCIÓN 4: Datos laborales";
                break; 
            case 'pE':
                $NombreSeccion="SECCIÓN 5: Satisfacción con la institución";
                break;         
        }
        return view('encuestaPosgrado.section',
                     compact('Encuesta','Egresado',
                            'Telefonos','Correos','section','Reactivos',
                            'Bloqueos','NombreSeccion'));
    }

    public function update_personal_data(Request $request,$id){
        $Encuesta=respuestasPosgrado::find($id);
        $Egresado=EgresadoPos::where('cuenta',$Encuesta->cuenta)->first();
        // dd($Egresado,$Encuesta);
        $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
        $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
        
        if($Encuesta->aplica2==1){
            $Encuesta->nbr2=Request::get('nbr2');
            $Encuesta->nbr3=Request::get('nbr3');
            $Encuesta->save();
            $Egresado->plantel=Request::get('nbr3');
            $Egresado->carrera=Request::get('nbr2');
            $Egresado->save();
            

        }
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
           $section='pA';
        
           foreach(array('pA','pE','pF','pC','pD','pG') as $sec){
               $format_field='sec_'.strtolower($sec);
              
               if($Encuesta->$format_field!=1){ 
                   $section=$sec;
                   break;
               }
           }
      return redirect()->route('enc_posgrado.section',[$Encuesta->registro,$section]);
    }

    public function update(Request $request,$id){
        
        $filteredArray = Arr::where(Request::except(['_token', '_method','btnradio','section']), function ($value, $key) {
            return $value != "on";
        });
        // dd(Request::all(),$filteredArray);
        $Encuesta=respuestasPosgrado::find($id);
        $Egresado=EgresadoPos::where('cuenta',$Encuesta->cuenta)->first();
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


        foreach(array('pA','pB','pC','pD','pE') as $sec){
            $format_field='sec_'.strtolower($sec);
           
            if($Encuesta->$format_field!=1){ 
                $section=$sec;
                break;
            }
        }
        if(($Encuesta->sec_pa==1)&&($Encuesta->sec_pb==1)&&($Encuesta->sec_pc==1)&&($Encuesta->sec_pd==1)&&($Encuesta->sec_pe==1)){
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
           return view('encuestaPosgrado.terminar',compact('Encuesta'));
        }else{

        }
        return redirect()->route('enc_posgrado.section',[$Encuesta->registro,$section]);
        // dd(Request::all());
    }
}
