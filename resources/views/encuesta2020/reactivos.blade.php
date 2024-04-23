@php
use \App\Http\Controllers\ReactivosController; 
@endphp
<h1 class="black_text"> {{$NombreSeccion}}</h1>
              
<form action="{{ route('enc20.update',$Encuesta->registro)}}" method="POST" enctype="multipart/form-data" id="main_form">
                   @csrf    
                   <input type="text" name="{{'sec_'.strtolower($Reactivos->first()->section)}}" value="1" hidden>
                   <input type="text" name="section" value="{{$Reactivos->first()->section}}" hidden>
                     
            @foreach($Reactivos as $reactivo)
                <div id="{{$reactivo->clave}}" style="padding: 1.2vw">
                <h3 id="{{$reactivo->clave.'-redact'}}" @if($reactivo->child==1) style="font-size:0.9vw" @endif>  @if($reactivo->child!=1) {{$reactivo->order}} @endif .- {{$reactivo->description}}</h3>
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