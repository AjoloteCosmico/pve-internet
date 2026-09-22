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

class EncContinuaController extends AbstractEncuestaController
{
    protected function getEncuestaModel()
    {
        return RespuestasContinua::class;
    }

    public function inicio(){
        //la primera vez, se intuye que esta en base y solo s emuestra la cuenta es decir, no es externo a la base de datos
        $Planteles=Carrera::select('clave_plantel','plantel')->distinct()->get()->sortBy('plantel');
        $Carreras=Carrera::where('clave_carrera','!=','501')->get()->sortBy('carrera');
        return view('encuesta_ed_continua.inicio',compact('Carreras','Planteles'));
    }

public function verify(Request $request){
        
        $cuenta = Request::get('cuenta');
        $datosValidados = $this->validarYFormatearCuenta($cuenta);
        
        if (!$datosValidados) {
            return redirect()->back()->with("cuenta", "invalida");
        }
        
        $cuenta = $datosValidados['cuenta'];
        $cuenta_formateada = $datosValidados['cuenta_formateada'];

        // BUSCAR EN BASE LICENCIATURA
        $Egresado = $this->buscarEgresadoLicenciatura($cuenta, $cuenta_formateada);
        
        if ($Egresado) {
            $Encuesta = $this->obtenerOCrearEncuesta($Egresado->cuenta, $Egresado);
            if ($Encuesta) {
                return redirect()->route('enc_continua.section', ['ed_continua', $Encuesta->registro]);
            }
        }

        // BUSCAR EN BASE POSGRADO
        $Egresado = $this->buscarEgresadoPosgrado($cuenta, $cuenta_formateada);
        
        if ($Egresado) {
            $Encuesta = $this->obtenerOCrearEncuesta($Egresado->cuenta, $Egresado);
            if ($Encuesta) {
                return redirect()->route('enc_continua.section', ['ed_continua', $Encuesta->registro]);
            }
        }

        // BUSCAR EN REGISTRO PVEAJU
        $Egresado = $this->buscarEgresadoRegistroPVEAJU($cuenta_formateada);
        
        if ($Egresado) {
            $Encuesta = $this->obtenerOCrearEncuesta($Egresado->exa_cuenta, $Egresado);
            if ($Encuesta) {
                return redirect()->route('enc_continua.section', ['ed_continua', $Encuesta->registro]);
            }
        }

        // CREAR EGRESADO DIRECTAMENTE
        if (Request::get('nombre')) {
            $Egresado = new Egresado();
            $Egresado->cuenta = $cuenta;
            $Egresado->fuente = 'encuesta ed continua';
            $Egresado->nombre = Request::get('nombre');
            $Egresado->paterno = Request::get('paterno');
            $Egresado->materno = Request::get('materno');
            $Egresado->carrera = Request::get('nbr2');
            $Egresado->plantel = Request::get('nbr3');
            $Egresado->anio_egreso = Request::get('anio_egreso');
            $Egresado->sexo = Request::get('sexo');
            $Egresado->save();
            
            $Encuesta = $this->obtenerOCrearEncuesta($Egresado->cuenta, $Egresado);
            if ($Encuesta) {
                return redirect()->route('enc_continua.section', ['ed_continua', $Encuesta->registro]);
            }
        } else {
            return redirect()->route('enc_continua.inicio')
                ->with('externo', 'si')
                ->with('cuenta', Request::get('cuenta'));
        }
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

    public function update(Request $request, $id){
      
        $filteredArray = Arr::where(Request::except(['_token', '_method', 'btnradio', 'section']), function ($value, $key) {
            return $value != "on";
        });

        $Encuesta = RespuestasContinua::find($id);
        $Encuesta->update($filteredArray);
        $Encuesta->fec_capt = now()->modify('-6 hours');
        $Encuesta->aplica = '111';
        $Encuesta->completed = '1';
        $Encuesta->save();
        
        // Guardar respuestas de preguntas múltiples
        $this->guardarRespuestasMultiples($Encuesta, 'ed_continua');
        
        // Actualizar estado del egresado en la muestra (ID: 897 para educación continua)
        $this->actualizarEstadoEgresadoMuestra($Encuesta, 897);

        return redirect()->route('enc_continua.section', ['personal_data', $Encuesta->registro]);
    }

    public function update_personal_data(Request $request, $id){
        $Encuesta = RespuestasContinua::find($id);
        
        // Guardar correos
        $this->guardarCorreos($Encuesta, Request::get('correos'));
        
        // Guardar teléfonos
        $this->guardarTelefonos($Encuesta, Request::get('telefonos'));
          
        return redirect()->route('enc_continua.inicio')->with('message', 'realized');
    }
}
