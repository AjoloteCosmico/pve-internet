<h3>{{$Reactivo->description}}</h3>

@foreach($Opciones as $option)
<div style="border: 1px solid black; border-radius: 1.3vw; padding:1.3vw; margin 2.5vw;">
<input type="checkbox" id="{{$Reactivo->clave.$option->clave}}" name="{{'option'.$option->clave}}" class="{{'op'.$Reactivo->clave}}" value="{{$option->clave}}"  onclick="multipleOptionWasClicked('{{$Reactivo->clave}}');">
  
{{$option->descripcion}} 
{{--{{$Bloqueos}}--}}
 </div>
<br>
@endforeach
