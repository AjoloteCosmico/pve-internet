@foreach($Opciones->sortBy('orden')  as $option)
<div id="{{'cuadrito'.$Reactivo->clave.$option->clave}}" class="{{'cuadrito-'.$Reactivo->clave}}" style="border: 1px solid black; border-radius: 1.3vw; padding:1.3vw; margin 2.5vw;"  onclick="optionWasClicked('{{$Reactivo->clave}}',[@foreach($Bloqueos as $b) @if($b->valor==$option->clave) '{{$b->bloqueado}}', @endif @endforeach ], [@foreach($Bloqueos->unique('bloqueado') as $b) '{{$b->bloqueado}}', @endforeach ],'{{$option->clave}}');">
   <input type="radio" id="{{$Reactivo->clave.'op'.$option->clave}}" name="{{$Reactivo->clave}}" class="{{'op'.$Reactivo->clave}}" value="{{$option->clave}}"  onclick="optionWasClicked('{{$Reactivo->clave}}',[@foreach($Bloqueos as $b) @if($b->valor==$option->clave) '{{$b->bloqueado}}', @endif @endforeach ], [@foreach($Bloqueos->unique('bloqueado') as $b) '{{$b->bloqueado}}', @endforeach ],'{{$option->clave}}');">
   <!--   {{$Reactivo->clave.$option->clave}} -->
   {{$option->descripcion}} 
   {{--{{$Bloqueos}}--}}
    
</div>
<br>
@endforeach