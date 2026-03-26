<?php

namespace App\Http\Controllers;
use Request;
use Illuminate\Support\Arr;
use App\Models\RespuestasVerdes;
use App\Models\Carrera;
use App\Models\Correo;
use App\Models\Telefono;
use App\Models\Egresado;
use App\Models\Reactivo;
use App\Models\Opcion;
use App\Models\Comentario;
use DB;
class EncVerdeController extends Controller
{
    public function inicio(){
        return view('encuestaVerde.inicio');
    }

public function verify(Request $request){
        
        $cuenta=Request::get('cuenta');
        $cuenta = ltrim($cuenta, "0"); 
        $Egresado=Egresado::where('cuenta',$cuenta)->whereIn('anio_egreso',[2022,2023,2024])->first();
        //TODO: CREAR TABLA CON LOS CAMPOS NESCESARIOS ASI COMO EL MODELO
        $Encuesta=RespuestasVerdes::where('cuenta',$cuenta)->first();
        //HAY EGRESADO
        if($Egresado){
            //LLENA LOS DATOS CON LA TABLA DE EG Y COMIENZA ENC
            if(!$Encuesta){
                $Encuesta=new RespuestasVerdes();
                $Encuesta->cuenta=$cuenta;
                $Encuesta->nombre=$Egresado->nombre;
                $Encuesta->paterno=$Egresado->paterno;
                $Encuesta->materno=$Egresado->materno;
                $Encuesta->nbr2=$Egresado->carrera;
                $Encuesta->nbr3=$Egresado->plantel;
                $Encuesta->save();
            }
             //comnzar encuesta 
            
            return redirect()->route('enc_verde.section',['encuesta_verde',$Encuesta->id]);
          }
          else{
          //NO ESSTA EN LA MIUESTRA DE POSGRADO
             
            //TYPE 2020
                //REDIRECCIONA A ENC GENERALs
                return redirect()->route('enc_verde.inicio')->with('message','notinsample');
                }              
    }

    public function section($section,$id){
        $Encuesta=RespuestasVerdes::find($id);
        
        $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->whereIn('anio_egreso',[2022,2023,2024])->first();
        $Carrera=Carrera::where('clave_carrera',$Encuesta->nbr2)->first()->carrera;
        $Plantel=Carrera::where('clave_plantel',$Encuesta->nbr3)->first()->plantel;
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
        
        return view('encuestaVerde.section',
                     compact('Encuesta','Egresado','Carrera','Plantel',
                            'Telefonos','Correos','section','Reactivos',
                            'Bloqueos'));
    }

    public function update(Request $request,$id){

        $filteredArray = Arr::where(Request::except(['_token', '_method','btnradio','section']), function ($value, $key) {
            return $value != "on";
        });
        // dd($filteredArray);
        $Encuesta=RespuestasVerdes::find($id);
        $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->where('carrera',$Encuesta->nbr2)->first();
        $Encuesta->update($filteredArray);
        $Encuesta->save();
        //actualizar tabla egresado_muestra status=2
        $EgMuestra=DB::table('egresado_muestra')
                ->where('egresado_id',$Egresado->id)
                ->where('muestra_id',898) //ID de muestra de educación continua
                ->update(['status' => 2,
                'updated_at'=>now()]);
        //return personal data update with mesage
        return redirect()->route('enc_verde.section',['personal_data',$Encuesta->id]);
            // return view('encuesta2016.terminar',compact('Encuesta'));
        }
    public function update_personal_data(Request $request,$id){
        $Encuesta=RespuestasVerdes::find($id);
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
          
      return redirect()->view('enc_verde.terminar')->with('teminada','ok');
    }

    public function terminar(){

    }
}
