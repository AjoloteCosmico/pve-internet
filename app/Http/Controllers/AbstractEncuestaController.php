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

abstract class AbstractEncuestaController extends Controller
{
    /**
     * Obtiene el modelo de encuesta que debe implementar cada controlador
     * @return string Nombre del modelo de encuesta
     */
    abstract protected function getEncuestaModel();

    /**
     * Busca un egresado en la base de licenciatura
     * @param string $cuenta Cuenta del egresado
     * @param string $cuenta_formateada Cuenta formateada con padding
     * @return object|null Egresado encontrado o null
     */
    protected function buscarEgresadoLicenciatura($cuenta, $cuenta_formateada)
    {
        $Egresado = Egresado::where('cuenta', $cuenta)->first();
        
        if (!$Egresado) {
            $Egresado = Egresado::where('cuenta', $cuenta_formateada)->first();
        }
        
        return $Egresado;
    }

    /**
     * Busca un egresado en la base de posgrado
     * @param string $cuenta Cuenta del egresado
     * @param string $cuenta_formateada Cuenta formateada con padding
     * @return object|null Egresado encontrado o null
     */
    protected function buscarEgresadoPosgrado($cuenta, $cuenta_formateada)
    {
        $Egresado = EgresadoPos::where('cuenta', $cuenta)->first();
        
        if (!$Egresado) {
            $Egresado = EgresadoPos::where('cuenta', $cuenta_formateada)->first();
        }
        
        return $Egresado;
    }

    /**
     * Busca un egresado en el registro PVEAJU
     * @param string $cuenta_formateada Cuenta formateada
     * @return object|null Egresado encontrado o null
     */
    protected function buscarEgresadoRegistroPVEAJU($cuenta_formateada)
    {
        return RegistroPVEAJU::where('exa_cuenta', $cuenta_formateada)
            ->orderByDesc('acad_afin')
            ->first();
    }

    /**
     * Obtiene la carrera desde un egresado de licenciatura
     * @param object $Egresado Egresado
     * @return string Nombre de la carrera
     */
    protected function obtenerCarreraLicenciatura($Egresado)
    {
        $CarreraRow = Carrera::where('clave_carrera', $Egresado->carrera)->first();
        return $CarreraRow ? $CarreraRow->carrera : "";
    }

    /**
     * Obtiene la edad desde una fecha de nacimiento
     * @param string $fecha_nacimiento Fecha de nacimiento
     * @return int|null Edad en años
     */
    protected function calcularEdad($fecha_nacimiento)
    {
        try {
            return date_diff(date_create($fecha_nacimiento), date_create('now'))->y ?? null;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Crea una nueva encuesta con datos del egresado de licenciatura
     * @param object $Egresado Egresado de licenciatura
     * @return object Encuesta creada
     */
    protected function crearEncuestaDeLicenciatura($Egresado)
    {
        $modelo = $this->getEncuestaModel();
        $Encuesta = new $modelo();
        $Encuesta->cuenta = $Egresado->cuenta;
        $Encuesta->nombre = $Egresado->nombre;
        $Encuesta->paterno = $Egresado->paterno;
        $Encuesta->materno = $Egresado->materno;
        $Encuesta->nbr2 = $Egresado->carrera;
        $Encuesta->nbr3 = $Egresado->plantel;
        $Encuesta->carrera = $this->obtenerCarreraLicenciatura($Egresado);
        $Encuesta->anio_egreso = $Egresado->anio_egreso;
        $Encuesta->sexo = $Egresado->sexo;
        $Encuesta->edad = $this->calcularEdad($Egresado->fec_nac);
        $Encuesta->save();
        
        return $Encuesta;
    }

    /**
     * Crea una nueva encuesta con datos del egresado de posgrado
     * @param object $Egresado Egresado de posgrado
     * @return object Encuesta creada
     */
    protected function crearEncuestaDePosgrado($Egresado)
    {
        $modelo = $this->getEncuestaModel();
        $Encuesta = new $modelo();
        $Encuesta->cuenta = $Egresado->cuenta;
        $Encuesta->nombre = $Egresado->nombre;
        $Encuesta->paterno = $Egresado->paterno;
        $Encuesta->materno = $Egresado->materno;
        $Encuesta->nbr2 = 0;
        $Encuesta->nbr3 = 0;
        $Encuesta->carrera = $Egresado->plan;
        $Encuesta->anio_egreso = $Egresado->anio_egreso;
        $Encuesta->sexo = $Egresado->sexo;
        $Encuesta->edad = $this->calcularEdad($Egresado->fec_nac);
        $Encuesta->save();
        
        return $Encuesta;
    }

    /**
     * Crea una nueva encuesta con datos del registro PVEAJU
     * @param object $Egresado Egresado del registro PVEAJU
     * @return object Encuesta creada
     */
    protected function crearEncuestaDeRegistroPVEAJU($Egresado)
    {
        $CarreraMap = MapeoCarrera::where('car_carrer', $Egresado->car_carrer)->first();
        $Carrera = '';
        
        if ($CarreraMap) {
            if ($CarreraMap->car_nivel == 'L') {
                $CarreraObj = Carrera::where('clave_carrera', $CarreraMap->carrera_id)->first();
                $Carrera = $CarreraObj ? $CarreraObj->carrera : '';
            } elseif ($CarreraMap->clave_programa) {
                $Carrera = 'Posgrado';
            }
        }

        $modelo = $this->getEncuestaModel();
        $Encuesta = new $modelo();
        $Encuesta->cuenta = $Egresado->exa_cuenta;
        $Encuesta->nombre = $Egresado->nombre;
        $Encuesta->paterno = $Egresado->primer_apellido;
        $Encuesta->materno = $Egresado->segundo_apellido;
        $Encuesta->nbr2 = $CarreraMap ? $CarreraMap->carrera_id : null;
        $Encuesta->nbr3 = $CarreraMap ? $CarreraMap->plantel_id : null;
        $Encuesta->carrera = $Carrera;
        $Encuesta->anio_egreso = $Egresado->acad_afin;
        $Encuesta->sexo = $Egresado->exa_sexo;
        $Encuesta->edad = $this->calcularEdad($Egresado->exa_fchnc);
        $Encuesta->save();
        
        return $Encuesta;
    }

    /**
     * Valida y formatea la cuenta
     * @param string $cuenta Cuenta a validar
     * @return array Array con keys 'cuenta' y 'cuenta_formateada'
     */
    protected function validarYFormatearCuenta($cuenta)
    {
        $cuenta = ltrim($cuenta, "0");
        $cuenta_formateada = str_pad($cuenta, 9, '0', STR_PAD_LEFT);
        
        if (!validar_cuenta($cuenta)) {
            return null;
        }
        
        return [
            'cuenta' => $cuenta,
            'cuenta_formateada' => $cuenta_formateada
        ];
    }

    /**
     * Obtiene o crea una encuesta para un egresado
     * @param string $cuenta Cuenta del egresado
     * @param object $Egresado Egresado encontrado
     * @return object|null Encuesta o null
     */
    protected function obtenerOCrearEncuesta($cuenta, $Egresado = null)
    {
        $modelo = $this->getEncuestaModel();
        $Encuesta = $modelo::where('cuenta', $Egresado->cuenta)->first();
        if (!$Egresado) {
            return null;
        }
        
        if (!$Encuesta) {
            if ($Egresado instanceof Egresado) {
                $Encuesta = $this->crearEncuestaDeLicenciatura($Egresado);
            } elseif ($Egresado instanceof EgresadoPos) {
                $Encuesta = $this->crearEncuestaDePosgrado($Egresado);
            } elseif ($Egresado instanceof RegistroPVEAJU) {
                $Encuesta = $this->crearEncuestaDeRegistroPVEAJU($Egresado);
            }
        }
        
        return $Encuesta;
    }

    /**
     * Guarda respuestas de preguntas múltiples
     * @param object $Encuesta Encuesta a actualizar
     * @param string $section Sección de la encuesta
     */
    protected function guardarRespuestasMultiples($Encuesta, $section)
    {
        $reativos_multiples = Reactivo::where('type', 'multiple_option')
            ->where('section', $section)
            ->get();
        
        foreach ($reativos_multiples as $r) {
            $clave = $r->clave;
            $selected_options = Arr::where(Request::except(['_token', '_method', 'btnradio', 'section']), 
                function ($value, $key) use ($clave) {
                    return str_contains($key, $clave . 'opcion');
                }
            );

            // Borramos las respuestas seleccionadas anteriores
            multiple_option_answer::where('encuesta_id', $Encuesta->registro)
                ->where('reactivo', $clave)
                ->delete();

            foreach ($selected_options as $key => $value) {
                $answer = new multiple_option_answer();
                $answer->encuesta_id = $Encuesta->registro;
                $answer->reactivo = $clave;
                $answer->clave_opcion = str_replace($clave . 'opcion', '', $key);
                $answer->save();
            }
        }
    }

    /**
     * Actualiza el estado del egresado en la muestra
     * @param object $Encuesta Encuesta actualizada
     * @param int $muestra_id ID de la muestra
     */
    protected function actualizarEstadoEgresadoMuestra($Encuesta, $muestra_id)
    {
        $Egresado = Egresado::where('cuenta', $Encuesta->cuenta)->first();
        
        if ($Egresado) {
            DB::table('egresado_muestra')
                ->where('egresado_id', $Egresado->id)
                ->where('muestra_id', $muestra_id)
                ->update([
                    'status' => 2,
                    'updated_at' => now()
                ]);
        }
    }

    /**
     * Guarda correos de contacto
     * @param object $Encuesta Encuesta
     * @param array $correos Array de correos a guardar
     */
    protected function guardarCorreos($Encuesta, $correos)
    {
        if (!is_array($correos)) {
            return;
        }

        $CorreosExistentes = Correo::where('cuenta', $Encuesta->cuenta)->get();

        foreach ($correos as $correo) {
            if ($correo != "" && $CorreosExistentes->where('correo', $correo)->count() == 0) {
                $CorreoModel = new Correo();
                $CorreoModel->cuenta = $Encuesta->cuenta;
                $CorreoModel->correo = $correo;
                $CorreoModel->status = 13;
                $CorreoModel->save();
            }
        }
    }

    /**
     * Guarda teléfonos de contacto
     * @param object $Encuesta Encuesta
     * @param array $telefonos Array de teléfonos a guardar
     */
    protected function guardarTelefonos($Encuesta, $telefonos)
    {
        if (!is_array($telefonos)) {
            return;
        }

        $TelefonosExistentes = Telefono::where('cuenta', $Encuesta->cuenta)->get();

        foreach ($telefonos as $telefono) {
            if ($telefono != "" && $TelefonosExistentes->where('telefono', $telefono)->count() == 0) {
                $TelefonoModel = new Telefono();
                $TelefonoModel->cuenta = $Encuesta->cuenta;
                $TelefonoModel->telefono = $telefono;
                $TelefonoModel->status = 13;
                $TelefonoModel->save();
            }
        }
    }
}
