<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
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
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use DB;

class Enc20Controller extends AbstractEncuestaController
{
    protected function getEncuestaModel()
    {
        return respuestas20::class;
    }

    private function normalizarTextoBusqueda($valor)
    {
        $valor = mb_strtoupper((string) $valor, 'UTF-8');
        $valor = str_replace(['Á','É','Í','Ó','Ú','Ä','Ë','Ï','Ö','Ü'], ['A','E','I','O','U','A','E','I','O','U'], $valor);
        $valor = str_replace(['á','é','í','ó','ú','ä','ë','ï','ö','ü'], ['A','E','I','O','U','A','E','I','O','U'], $valor);
        $valor = preg_replace('/[^A-Z0-9]/u', '', $valor);

        return $valor;
    }

    private function coincidenApellidos($apellidoIngresado, $apellidoBase)
    {
        $apellidoIngresado = $this->normalizarTextoBusqueda($apellidoIngresado);
        $apellidoBase = $this->normalizarTextoBusqueda($apellidoBase);

        if ($apellidoIngresado === '' || $apellidoBase === '') {
            return false;
        }

        if ($apellidoIngresado === $apellidoBase) {
            return true;
        }

        similar_text($apellidoIngresado, $apellidoBase, $porcentaje);

        return $porcentaje >= 80;
    }

    private function validarApellidoConCuenta($cuenta, $cuenta_formateada, $apellidoIngresado)
    {
        $apellidoIngresado = trim((string) $apellidoIngresado);

        $registros = [
            ['model' => Egresado::class, 'campo_cuenta' => 'cuenta'],
            ['model' => \App\Models\EgresadoPos::class, 'campo_cuenta' => 'cuenta'],
        ];

        foreach ($registros as $registro) {
            $modelo = $registro['model'];
            $query = $modelo::query();
            $query->where($registro['campo_cuenta'], $cuenta)
                ->orWhere($registro['campo_cuenta'], $cuenta_formateada);

            $resultado = $query->first();
            if ($resultado) {
                $apellidos = [
                    $resultado->paterno ?? '',
                    $resultado->materno ?? '',
                ];

                foreach ($apellidos as $apellido) {
                    if ($this->coincidenApellidos($apellidoIngresado, $apellido)) {
                        return true;
                    }
                }

                return false;
            }
        }

        $registro = \App\Models\RegistroPVEAJU::where('exa_cuenta', $cuenta_formateada)->first();
        if ($registro) {
            $apellidos = [
                $registro->primer_apellido ?? '',
                $registro->segundo_apellido ?? '',
            ];

            foreach ($apellidos as $apellido) {
                if ($this->coincidenApellidos($apellidoIngresado, $apellido)) {
                    return true;
                }
            }

            return false;
        }

        return null;
    }

    private function buscarEgresadoGeneral($cuenta, $cuenta_formateada)
    {
        $resultado = Egresado::where('cuenta', $cuenta)->first();
        if (!$resultado) {
            $resultado = Egresado::where('cuenta', $cuenta_formateada)->first();
        }
        if ($resultado) {
            return [
                'fuente' => 'egresado',
                'datos' => $resultado,
            ];
        }

        $resultado = \App\Models\EgresadoPos::where('cuenta', $cuenta)->first();
        if (!$resultado) {
            $resultado = \App\Models\EgresadoPos::where('cuenta', $cuenta_formateada)->first();
        }
        if ($resultado) {
            return [
                'fuente' => 'posgrado',
                'datos' => $resultado,
            ];
        }

        $resultado = \App\Models\RegistroPVEAJU::where('exa_cuenta', $cuenta_formateada)->first();
        if ($resultado) {
            return [
                'fuente' => 'registro',
                'datos' => $resultado,
            ];
        }

        return null;
    }

    private function construirDatosDesdeFuente($fuente, $row)
    {
        if ($fuente === 'egresado') {
            return [
                'nombre' => $row->nombre ?? '',
                'paterno' => $row->paterno ?? '',
                'materno' => $row->materno ?? '',
                'nbr2' => $row->carrera ?? '',
                'nbr3' => $row->plantel ?? '',
                'gen_dgae' => $row->anio_egreso ?? null,
                'edad' => $row->edad ?? null,
            ];
        }

        if ($fuente === 'posgrado') {
            return [
                'nombre' => $row->nombre ?? '',
                'paterno' => $row->paterno ?? '',
                'materno' => $row->materno ?? '',
                'nbr2' => null,
                'nbr3' => null,
                'gen_dgae' => $row->anio_egreso ?? null,
                'edad' => $row->edad ?? null,
            ];
        }

        if ($fuente === 'registro') {
            $CarreraMap = \App\Models\mapeoCarrera::where('car_carrer', $row->car_carrer)->first();
            $Carrera = '';
            $plantel = null;
            $claveCarrera = null;

            if ($CarreraMap) {
                $plantel = $CarreraMap->plantel_id ?? null;
                $claveCarrera = $CarreraMap->carrera_id ?? null;

                if ($CarreraMap->car_nivel == 'L') {
                    $CarreraObj = Carrera::where('clave_carrera', $CarreraMap->carrera_id)->first();
                    $Carrera = $CarreraObj ? $CarreraObj->carrera : '';
                } elseif ($CarreraMap->clave_programa) {
                    $Carrera = 'Posgrado';
                }
            }

            return [
                'nombre' => $row->nombre ?? '',
                'paterno' => $row->primer_apellido ?? '',
                'materno' => $row->segundo_apellido ?? '',
                'nbr2' => $claveCarrera,
                'nbr3' => $plantel,
                'gen_dgae' => $row->acad_afin ?? null,
                'edad' => $this->calcularEdad($row->exa_fchnc ?? null),
                'carrera_label' => $Carrera,
            ];
        }

        return [
            'nombre' => '',
            'paterno' => '',
            'materno' => '',
            'nbr2' => null,
            'nbr3' => null,
            'gen_dgae' => null,
            'edad' => null,
        ];
    }

    private function datosExternosValidos(Request $request)
    {
        foreach (['nombre','paterno','materno','nbr2','nbr3','sexo','anio_egreso','edad'] as $campo) {
            if (trim((string) $request->get($campo, '')) === '') {
                return false;
            }
        }

        return true;
    }

    public function inicio($type){
        if($type!= '2020'&&$type!='general'&&$type!='2022'&&$type!='2021'){
            return redirect()->route('enc.inicio','general');
        }
        return view('encuesta2020.inicio',compact('type'));
    }

    public function verify(Request $request, $type){

        $cuenta_raw = $request->get('cuenta');
        $cuenta = $request->get('cuenta');
        $datosValidados = $this->validarYFormatearCuenta($cuenta);

        if (!$datosValidados) {
            return redirect()->back()->with('message', 'cuenta_invalida')->withInput();
        }

        $cuenta = $datosValidados['cuenta'];
        $cuenta_formateada = $datosValidados['cuenta_formateada'];

        $Egresado = $this->buscarEgresadoGeneral($cuenta, $cuenta_formateada);

        if ($Egresado) {
            $fuente = $Egresado['fuente'];
            $row = $Egresado['datos'];
            $datosFuente = $this->construirDatosDesdeFuente($fuente, $row);

            if ($type == 'general') {
                $apellidoIngresado = trim((string) $request->get('paterno', ''));
                $apellidoValido = false;

                if ($fuente === 'egresado' || $fuente === 'posgrado') {
                    $apellidoValido = $this->coincidenApellidos($apellidoIngresado, $row->paterno ?? '') || $this->coincidenApellidos($apellidoIngresado, $row->materno ?? '');
                } elseif ($fuente === 'registro') {
                    $apellidoValido = $this->coincidenApellidos($apellidoIngresado, $row->primer_apellido ?? '') || $this->coincidenApellidos($apellidoIngresado, $row->segundo_apellido ?? '');
                }

                if (!$apellidoValido) {
                    return redirect()->route('enc.inicio', 'general')->with('message', 'apellido_incorrecto')->with('cuenta', $cuenta_raw);
                }
            }

            $muestra = property_exists($row, 'muestra') ? (int) $row->muestra : null;
            $actSuvery = property_exists($row, 'act_suvery') ? (int) $row->act_suvery : null;

            if ($muestra == 3) {
                $Encuesta = respuestas20::where('cuenta', $cuenta)->first();

                if (!$Encuesta) {
                    $Encuesta = new respuestas20();
                    $Encuesta->cuenta = $cuenta;
                    $Encuesta->nombre = $row->nombre;
                    $Encuesta->paterno = $row->paterno;
                    $Encuesta->materno = $row->materno;
                    $Encuesta->nbr2 = $datosFuente['nbr2'];
                    $Encuesta->nbr3 = $datosFuente['nbr3'];
                    $Encuesta->gen_dgae = $datosFuente['gen_dgae'];
                    $Encuesta->completed = 0;
                    $Encuesta->save();
                }

                if($Encuesta->completed != 1){
                    return redirect()->route('enc20.section', [$Encuesta->registro, 'personal_data']);
                } else {
                    return redirect()->route('enc.inicio', $type)->with('message', 'realized')->with('cuenta', $cuenta_raw);
                }
            }

            elseif ($muestra == 5) {
                $Encuesta = respuestas20::where('cuenta', $cuenta)->first();

                if (!$Encuesta) {
                    $Encuesta = new respuestas20();
                    $Encuesta->cuenta = $cuenta;
                    $Encuesta->nombre = $row->nombre;
                    $Encuesta->paterno = $row->paterno;
                    $Encuesta->materno = $row->materno;
                    $Encuesta->nbr2 = $datosFuente['nbr2'];
                    $Encuesta->nbr3 = $datosFuente['nbr3'];
                    $Encuesta->gen_dgae = $datosFuente['gen_dgae'];
                    $Encuesta->completed = 0;
                    $Encuesta->save();
                }

                if($Encuesta->completed != 1){
                    return redirect()->route('enc20.section', [$Encuesta->registro, 'personal_data']);
                } else {
                    return redirect()->route('enc.inicio', $type)->with('message', 'realized')->with('cuenta', $cuenta_raw);
                }
            }

            elseif ($actSuvery == 1) {
                $Encuesta = respuestas16::where('cuenta', $cuenta)->first();

                if (!$Encuesta) {
                    $Encuesta = new respuestas16();
                    $Encuesta->cuenta = $cuenta;
                    $Encuesta->nombre = $row->nombre;
                    $Encuesta->paterno = $row->paterno;
                    $Encuesta->materno = $row->materno;
                    $Encuesta->nbr2 = $datosFuente['nbr2'];
                    $Encuesta->nbr3 = $datosFuente['nbr3'];
                    $Encuesta->completed = 0;
                    $Encuesta->save();
                }

                if ($Encuesta->completed != 1) {
                    return redirect()->route('enc16.section', [$Encuesta->registro, 'personal_data']);
                } else {
                    return redirect()->route('enc16.inicio', '2016')->with('message', 'realized')->with('cuenta', $cuenta_raw);
                }
            }

            else {
                if($type == 'general'){
                    $Encuesta = respuestas20::where('cuenta', $cuenta)->first();
                    if(!$Encuesta){
                        $Encuesta = new respuestas20();
                        $Encuesta->cuenta = $cuenta;
                        $Encuesta->aplica2 = 1;
                        $Encuesta->nombre = $datosFuente['nombre'];
                        $Encuesta->paterno = $datosFuente['paterno'];
                        $Encuesta->materno = $datosFuente['materno'];
                        $Encuesta->nbr2 = $datosFuente['nbr2'];
                        $Encuesta->nbr3 = $datosFuente['nbr3'];
                        $Encuesta->gen_dgae = $datosFuente['gen_dgae'];
                        $Encuesta->completed = 0;
                        $Encuesta->save();
                    }

                    if($Encuesta->completed != 1){
                        return redirect()->route('enc20.section',[$Encuesta->registro,'personal_data']);
                    } else {
                        return redirect()->route('enc.inicio','general')->with('message','realized')->with('cuenta', $cuenta_raw);
                    }
                }

                return redirect()->route('enc.inicio','general')->with('message','notinsample')->with('cuenta', $cuenta_raw);
            }
        }

        if($type == 'general'){
            $apellidoIngresado = trim((string) $request->get('paterno', ''));
            if ($apellidoIngresado === '') {
                return redirect()->back()->with('message', 'paterno_requerido')->withInput();
            }

            if (!$this->datosExternosValidos($request)) {
                return redirect()->route('enc.inicio', 'general')
                    ->with('externo', 'si')
                    ->with('cuenta', $cuenta_raw)
                    ->withInput();
            }

            $EgresadoExterno = $this->crearEgresadoExternoDesdeFormulario($request, $cuenta);
            if (!$EgresadoExterno) {
                return redirect()->route('enc.inicio', 'general')
                    ->with('externo', 'si')
                    ->with('cuenta', $cuenta_raw)
                    ->withInput();
            }

            $Encuesta = respuestas20::where('cuenta', $cuenta)->first();
            if(!$Encuesta){
                $Encuesta = new respuestas20();
                $Encuesta->cuenta = $cuenta;
                $Encuesta->aplica2 = 1;
                $Encuesta->nombre = $EgresadoExterno->nombre;
                $Encuesta->paterno = $EgresadoExterno->paterno;
                $Encuesta->materno = $EgresadoExterno->materno;
                $Encuesta->nbr2 = $EgresadoExterno->carrera;
                $Encuesta->nbr3 = $EgresadoExterno->plantel;
                $Encuesta->gen_dgae = $EgresadoExterno->anio_egreso;
                $Encuesta->completed = 0;
                $Encuesta->save();
            }

            if($Encuesta->completed != 1){
                return redirect()->route('enc20.section',[$Encuesta->registro,'personal_data']);
            } else {
                return redirect()->route('enc.inicio','general')->with('message','realized')->with('cuenta', $cuenta_raw);
            }
        }

        return redirect()->route('enc.inicio','general')->with('message','notinsample')->with('cuenta', $cuenta_raw);
    }



    public function section($id,$section){
        $Encuesta=respuestas20::find($id);
        if (!$Encuesta) {
            return redirect()->route('enc.inicio', 'general')->with('message', 'cuenta_invalida');
        }

        $Egresado = Egresado::where('cuenta', $Encuesta->cuenta)->first();
        if (!$Egresado) {
            $Egresado = \App\Models\EgresadoPos::where('cuenta', $Encuesta->cuenta)->first();
        }
        if (!$Egresado) {
            $Egresado = \App\Models\RegistroPVEAJU::where('exa_cuenta', $Encuesta->cuenta)->first();
        }

        if (!$Egresado) {
            $Egresado = (object) [
                'cuenta' => $Encuesta->cuenta,
                'nombre' => $Encuesta->nombre ?? '',
                'paterno' => $Encuesta->paterno ?? '',
                'materno' => $Encuesta->materno ?? '',
                'sexo' => $Encuesta->sexo ?? null,
                'fec_nac' => null,
                'promedio' => null,
                'fuente' => 'encuesta',
                'anio_egreso' => $Encuesta->gen_dgae ?? null,
                'carrera' => $Encuesta->nbr2 ?? null,
                'plantel' => $Encuesta->nbr3 ?? null,
            ];
        }

        $Carrera = ' ';
        $Plantel = ' ';
        $Planteles = [];
        $Carreras = [];

        if($Encuesta->aplica2==1){
            $Planteles = Carrera::select('clave_plantel','plantel')->distinct()->get();
            $Carreras = Carrera::all();

            if($Encuesta->nbr2){
                $CarreraRow = Carrera::where('clave_carrera', '=', $Encuesta->nbr2)->first();
                $PlantelRow = Carrera::where('clave_plantel', '=', $Encuesta->nbr3)->first();

                if ($CarreraRow) {
                    $Carrera = $CarreraRow->carrera;
                }
                if ($PlantelRow) {
                    $Plantel = $PlantelRow->plantel;
                }
            }
        } else {
            if ($Egresado) {
                $carreraRow = Carrera::where('clave_carrera', '=', $Egresado->carrera)->first();
                $plantelRow = Carrera::where('clave_plantel', '=', $Egresado->plantel)->first();

                if ($carreraRow) {
                    $Carrera = $carreraRow->carrera;
                }
                if ($plantelRow) {
                    $Plantel = $plantelRow->plantel;
                }
            }
            $Planteles = ' ';
            $Carreras = ' ';
        }

        $Comentario = ''.Comentario::where('cuenta', '=', $Encuesta->cuenta)->first();
        $Telefonos = collect();
        $Correos = collect();
        if ($Egresado) {
            $Telefonos = Telefono::where('cuenta', $Egresado->cuenta)->get();
            $Correos = Correo::where('cuenta', $Egresado->cuenta)->get();
        }

        $Generacion = null;
        if ($Encuesta->gen_dgae) {
            $Generacion = $Encuesta->gen_dgae;
        } elseif ($Egresado && $Egresado->anio_egreso) {
            $Generacion = $Egresado->anio_egreso;
        }

        $Coment=Comentario::where('cuenta','=',$Encuesta->cuenta)->first();
        if($section!='personal_data'){
            $Bloqueos=DB::table('bloqueos')->join('reactivos','bloqueos.clave_reactivo','reactivos.clave')
            ->where('reactivos.section','=',$section)
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
                            'Bloqueos','NombreSeccion','Planteles','Carreras','Generacion'));
    }

    public function update_personal_data(Request $request,$id){ 

        //Agregamos la validacion correspondiente a telefonos y correos

        $request->validate([
            'correos.*' => [
                'nullable',
                'email',
                'max:255',
                'unique:correos,correo',
                'distinct:ignore_case',
            ],
            'telefonos.*' => [
                'nullable',
                'string',
                'max:20',
                'min:10',
                'unique:telefonos,telefono',
                'distinct',
            ],
        ], [
            'correos.*.unique' => 'El correo electrónico ya está registrado en la base de datos.',
            'correos.*.distrinct' => 'El correo electrónico :input está duplicado en el formulario.',
            'telefonos.*.unique' => 'El número de teléfono ya está registrado en la base de datos.',
            'telefonos.*.distinct' => 'El número de teléfono :input está duplicado en el formulario.',


        ]);


        $Encuesta=respuestas20::find($id);
        $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->first();
        // dd($Egresado,$Encuesta);
        $Telefonos=Telefono::where('cuenta',$Egresado->cuenta)->get();       
        $Correos=Correo::where('cuenta',$Egresado->cuenta)->get();       
        
        if($Encuesta->aplica2==1){
            $Encuesta->nbr2= $request->get('nbr2');
            $Encuesta->nbr3= $request->get('nbr3');
            $Encuesta->save();
            $Egresado->plantel= $request->get('nbr3');
            $Egresado->carrera= $request->get('nbr2');
            $Egresado->anio_egreso= $request->get('anio_egreso');
            $Egresado->save();
        }


        foreach ($request->get('correos') as $correo) {
            //cambiamos el if
         if($correo!=""){
            if($Correos->where('correo',$correo)->count()==0){
                $Correo= new Correo();
                $Correo->cuenta=$Encuesta->cuenta;
                $Correo->correo=$correo;
                $Correo->status=13;
                $Correo->save();

            }
         }
        }

        foreach ($request->get('telefonos') as $telefono) {
            //cambiamos e if
            if($telefono!=""){
                if($Telefonos->where('telefono',$telefono)->count()==0){
                    $Telefono= new Telefono();
                    $Telefono->cuenta=$Encuesta->cuenta;
                    $Telefono->telefono=$telefono;
                    $Telefono->status=13;
                    $Telefono->save();
                }
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
        
        $filteredArray = Arr::where($request->except(['_token', '_method','btnradio','section']), function ($value, $key) {
            return $value != "on";
        });
        // dd(Request::all(),$filteredArray);
        $Encuesta=respuestas20::find($id);
        $Egresado=Egresado::where('cuenta',$Encuesta->cuenta)->where('carrera',$Encuesta->nbr2)->first();
        $Encuesta->update($filteredArray);
        $Encuesta->save();
        // dd(Request::all(),$filteredArray);
        $section= $request->get('section');
        
        //si la seccion contiene reactivos multiples,  iteramos sobre ellos
        $reativos_multiples=Reactivo::where('type','multiple_option')->where('section',$section)->get();
        foreach($reativos_multiples as $r){
            $clave=$r->clave;
            $selected_options = Arr::where($request->except(['_token', '_method','btnradio','section']), function ($value, $key) use($clave){
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
            $qrString='seg'.$Egresado->cuenta.' '.$Encuesta->registro.'_'.now()->format('Ymd');
            $qrCode = QrCode::size(200)
                       ->color(5,10,48)
                       ->style('round')
                       ->generate($qrString);
           return view('encuesta2020.terminar',compact('Encuesta','qrCode'));
        }else{

        }
        return redirect()->route('enc20.section',[$Encuesta->registro,$section]);
        // dd(Request::all());
    }

    private function necesitaDatosExternosGeneral($request, $Egresado = null)
    {
        $nombre = trim((string) ($request->get('nombre') ?? ($Egresado->nombre ?? '')));
        $paterno = trim((string) ($request->get('paterno') ?? ($Egresado->paterno ?? '')));
        $materno = trim((string) ($request->get('materno') ?? ($Egresado->materno ?? '')));
        $nbr2 = trim((string) ($request->get('nbr2') ?? ($Egresado->carrera ?? '')));
        $nbr3 = trim((string) ($request->get('nbr3') ?? ($Egresado->plantel ?? '')));
        $sexo = trim((string) ($request->get('sexo') ?? ($Egresado->sexo ?? '')));
        $anioEgreso = trim((string) ($request->get('anio_egreso') ?? ($Egresado->anio_egreso ?? '')));
        $edad = trim((string) ($request->get('edad') ?? ($Egresado->edad ?? '')));

        return $nombre === '' || $paterno === '' || $materno === '' || $nbr2 === '' || $nbr3 === '' || $sexo === '' || $anioEgreso === '' || $edad === '';
    }

    private function crearEncuestaGeneralDesdeEgresado($cuenta, $Egresado, $request)
    {
        $nombre = trim((string) ($Egresado->nombre ?? $request->get('nombre')));
        $paterno = trim((string) ($Egresado->paterno ?? $request->get('paterno')));
        $materno = trim((string) ($Egresado->materno ?? $request->get('materno')));
        $nbr2 = trim((string) ($Egresado->carrera ?? $request->get('nbr2')));
        $nbr3 = trim((string) ($Egresado->plantel ?? $request->get('nbr3')));

        if ($nombre === '' || $paterno === '' || $materno === '' || $nbr2 === '' || $nbr3 === '') {
            return null;
        }

        $Encuesta = respuestas20::where('cuenta', $cuenta)->first();
        if (!$Encuesta) {
            $Encuesta = new respuestas20();
            $Encuesta->cuenta = $cuenta;
            $Encuesta->aplica2 = 1;
            $Encuesta->nombre = $nombre;
            $Encuesta->paterno = $paterno;
            $Encuesta->materno = $materno;
            $Encuesta->nbr2 = $nbr2;
            $Encuesta->nbr3 = $nbr3;
            $Encuesta->gen_dgae = $Egresado->anio_egreso ?? $request->get('anio_egreso');
            $Encuesta->completed = 0;
            $Encuesta->save();
        }

        return $Encuesta;
    }

    private function crearEgresadoExternoDesdeFormulario(Request $request, $cuenta)
    {
        $nombre = trim((string) $request->get('nombre'));
        $paterno = trim((string) $request->get('paterno'));
        $materno = trim((string) $request->get('materno'));
        $nbr2 = trim((string) $request->get('nbr2'));
        $nbr3 = trim((string) $request->get('nbr3'));
        $sexo = trim((string) $request->get('sexo'));
        $anioEgreso = trim((string) $request->get('anio_egreso'));
        $edad = trim((string) $request->get('edad'));

        if ($nombre === '' || $paterno === '' || $materno === '' || $nbr2 === '' || $nbr3 === '' || $sexo === '' || $anioEgreso === '' || $edad === '') {
            return null;
        }

        $Egresado = new Egresado();
        $Egresado->cuenta = $cuenta;
        $Egresado->fuente = 'encuesta externa';
        $Egresado->nombre = $nombre;
        $Egresado->paterno = $paterno;
        $Egresado->materno = $materno;
        $Egresado->carrera = $nbr2;
        $Egresado->plantel = $nbr3;
        $Egresado->anio_egreso = $anioEgreso;
        $Egresado->sexo = $sexo;
        $Egresado->edad = $edad;
        $Egresado->save();

        return $Egresado;
    }

    private function datosGeneralesCompletos($request, $Egresado = null)
    {
        $datos = [
            trim((string) ($request->get('nombre') ?? ($Egresado->nombre ?? ''))),
            trim((string) ($request->get('paterno') ?? ($Egresado->paterno ?? ''))),
            trim((string) ($request->get('materno') ?? ($Egresado->materno ?? ''))),
            trim((string) ($request->get('nbr2') ?? ($Egresado->carrera ?? ''))),
            trim((string) ($request->get('nbr3') ?? ($Egresado->plantel ?? ''))),
            trim((string) ($request->get('sexo') ?? ($Egresado->sexo ?? ''))),
            trim((string) ($request->get('anio_egreso') ?? ($Egresado->anio_egreso ?? ''))),
            trim((string) ($request->get('edad') ?? ($Egresado->edad ?? ''))),
        ];

        foreach ($datos as $valor) {
            if ($valor === '') {
                return false;
            }
        }

        return true;
    }

    private function crearEgresadoTemporalDesdeEncuesta($Encuesta)
    {
        if (!$Encuesta) {
            return null;
        }

        return (object) [
            'cuenta' => $Encuesta->cuenta,
            'nombre' => $Encuesta->nombre,
            'paterno' => $Encuesta->paterno,
            'materno' => $Encuesta->materno,
            'sexo' => $Encuesta->sexo,
            'fec_nac' => null,
            'carrera' => $Encuesta->nbr2,
            'plantel' => $Encuesta->nbr3,
            'anio_egreso' => $Encuesta->gen_dgae,
            'edad' => $Encuesta->edad,
            'promedio' => null,
        ];
    }
}
