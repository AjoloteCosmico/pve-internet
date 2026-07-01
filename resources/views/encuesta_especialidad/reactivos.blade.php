@php
use \App\Http\Controllers\ReactivosController;
$reactivosEnTablas=array();
@endphp
<h1 class="black_text"> Encuesta de Especialidades Derecho UNAM</h1>
<p style="font-size: 24px; color: #333;"> La información que nos proporcione en este cuestionario será referente a su especialidad en: <b>{{$Encuesta->especialidad}}</b> </p>

<form action="{{ route('enc_esp.update',$Encuesta->registro)}}" method="POST" enctype="multipart/form-data" id="main_form">
                   @csrf    
                  <input type="text" name="section" value="{{$Reactivos->first()->section}}" hidden>
                 <input type="text" name="{{'sec_'.strtolower($Reactivos->first()->section)}}" value="1" hidden>    
            @foreach($Reactivos as $reactivo)
             @if(!in_array($reactivo->clave,$reactivosEnTablas))
                 @if($reactivo->type == 'table')
                    @php
                        $tableConfig = json_decode(strval($reactivo->rules), true);
                        $columns     = $tableConfig['columns'] ?? [];
                        $rows        = $tableConfig['rows']    ?? [];

                        // Normalizar: si rows es plano, convertir a arreglo de arreglos
                        $rows_normalized = [];
                        foreach ($rows as $row) {
                            $rows_normalized[] = is_array($row) ? $row : [$row];
                        }

                        // Precargar todos los reactivos necesarios de una sola vez
                        $all_claves = collect($rows_normalized)->flatten()->unique()->values();
                        $reactivos_tabla = \App\Models\Reactivo::whereIn('clave', $all_claves)->get()->keyBy('clave');
                        $reactivosEnTablas= array_merge($reactivosEnTablas,$reactivos_tabla->pluck('clave')->toArray());
                       
                    @endphp

                    @include('components.reactivos.table', [
                        'Reactivo'        => $reactivo,
                        'Columns'         => $columns,
                        'RowsNormalized'  => $rows_normalized,
                        'ReactivosTabla'  => $reactivos_tabla,
                        'Encuesta'        => $Encuesta,
                        'Reactivos'       => $Reactivos
                    ])
                @else
                    <div id="{{$reactivo->clave}}" style="padding: 1.2vmax;  @if($reactivo->child==1) padding-left:4.4vmax !important @endif" >
                
                    @if($reactivo->child==1) 
                    <h4 id="{{$reactivo->clave.'-redact'}}">  @if($reactivo->child!=1 && $reactivo->type!='label') {{$reactivo->orden}} .- @endif @if($reactivo->act_description) {{$reactivo->act_description}} @else {{$reactivo->description}} @endif</h4>
                    @else
                    <h3 id="{{$reactivo->clave.'-redact'}}">  @if($reactivo->child!=1 && $reactivo->type!='label') {{$reactivo->orden}} .- @endif @if($reactivo->act_description) {{$reactivo->act_description}} @else {{$reactivo->description}} @endif</h3>
                    @endif
                    
                    @if($reactivo->extra_label)
                        <h4>{{$reactivo->extra_label}} </h4>
                    @endif
            

                    {{ReactivosController::chooseType($reactivo->id,$Reactivos)}}
                    </div>
                @endif
            
            @endif
            @endforeach
            <div class="continuarBtn">
                <button class="btn blue_button" type="button" id="final-button" onclick="submitForm()" disabled> Guardar y Siguiente</button>
            </div>
</form>
<div id='monitor_reactivos_cerrrados' style="position: fixed; top: 20px; left: 20px; background:white; color: black; heigth:10.5vw;">
</div>