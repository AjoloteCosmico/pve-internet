
<select name="{{$Reactivo->clave}}" id="">
@foreach($Opciones as $option)
<!-- <input type="radio" id="{{$Reactivo->clave.$option->clave}}" name="{{$Reactivo->clave}}" class="{{'op'.$Reactivo->clave}}" value="{{$option->clave}}"  onclick="optionWasClicked('{{$Reactivo->clave}}',[@foreach($Bloqueos as $b) @if($b->valor==$option->clave) '{{$b->bloqueado}}', @endif @endforeach ], [@foreach($Bloqueos as $b) '{{$b->bloqueado}}', @endforeach ]);"> -->
 <option value="{{$option->clave}} " onclick="optclick()">{{$option->descripcion}} </option> 


<br>
@endforeach
</select>

