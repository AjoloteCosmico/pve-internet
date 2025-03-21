@php
use \App\Http\Controllers\ReactivosController;

@endphp
<h1 class="black_text"> {{$NombreSeccion}}</h1>

<form action="{{ route('enc16.update',$Encuesta->registro)}}" method="POST" enctype="multipart/form-data" id="main_form">
                   @csrf    
                   <input type="text" name="{{'sec_'.strtolower($Reactivos->first()->section)}}" value="1" hidden>
                   <input type="text" name="section" value="{{$Reactivos->first()->section}}" hidden>
                     
            @foreach($Reactivos as $reactivo)
                <div id="{{$reactivo->clave}}" style="padding: 1.2vmax;  @if($reactivo->child==1) padding-left:4.4vmax !important @endif" >
               
                @if($reactivo->child==1) 
                   <h4 id="{{$reactivo->clave.'-redact'}}">  @if($reactivo->child!=1 && $reactivo->type!='label') {{$reactivo->orden}} .- @endif {{$reactivo->description}}</h4>
                @else
                   <h3 id="{{$reactivo->clave.'-redact'}}">  @if($reactivo->child!=1 && $reactivo->type!='label') {{$reactivo->orden}} .- @endif {{$reactivo->description}}</h3>
                @endif
                
                @if($reactivo->extra_label)
                    <h4>{{$reactivo->extra_label}} </h4>
                @endif

            {{ReactivosController::chooseType($reactivo->id)}}
            </div>
            @endforeach
            <div class="continuarBtn">
                <button class="btn blue_button" type="button" id="final-button" onclick="submitForm()" disabled> Guardar y Siguiente</button>
            </div>
</form>
<div id='monitor_reactivos_cerrrados' style="position: fixed; top: 20px; left: 20px; background:white; color: black; heigth:10.5vw;">
</div>