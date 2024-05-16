
<select name="{{$Reactivo->clave}}" id="{{'select-'.$Reactivo->clave}}" onchange="optionWasSelected('{{$Reactivo->clave}}',[@foreach($Bloqueos->unique('bloqueado') as $b) '{{$b->bloqueado}}', @endforeach ])">
<option value="" >Seleccione... </option> 

@foreach($Opciones as $option)
<!-- <input type="radio" id="{{$Reactivo->clave.$option->clave}}" name="{{$Reactivo->clave}}" class="{{'op'.$Reactivo->clave}}" value="{{$option->clave}}"  
onclick="optionWasClicked('{{$Reactivo->clave}}',[@foreach($Bloqueos as $b) @if($b->valor==$option->clave) '{{$b->bloqueado}}', @endif @endforeach ], [@foreach($Bloqueos as $b) '{{$b->bloqueado}}', @endforeach ]);"> -->
 <option value="{{$option->clave}} " >{{$option->descripcion}} </option> 


<br>
@endforeach
</select>

