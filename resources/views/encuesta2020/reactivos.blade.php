@php
use \App\Http\Controllers\ReactivosController; 
@endphp
<form action="{{ route('enc20.update',$Encuesta->registro)}}" method="POST" enctype="multipart/form-data" id="main_form">
                   @csrf    
                   <input type="text" name="{{'sec_'.strtolower($Reactivos->first()->section)}}" value="1" hidden>
                   <input type="text" name="section" value="{{$Reactivos->first()->section}}" hidden>
           
                  
            @foreach($Reactivos as $reactivo)
            <div id="{{$reactivo->clave}}" style="padding: 1.2vw">
            <!-- {{$reactivo->clave}} -->
            {{ReactivosController::chooseType($reactivo->id)}}
            </div>
            @endforeach
          
            <div class="continuarBtn">
                <button class="btn blue_button" type="button" id="final-button" onclick="submitForm()" disabled> Guardar y Siguiente</button>
            </div>
</form>