
@foreach($Opciones as $option)
<div style="border: 1px solid black; border-radius: 1.3vw; padding:1.3vw; margin 2.5vw;">
<input type="radio" id="{{$Reactivo->clave.$option->clave}}" name="{{$Reactivo->clave}}" class="{{'op'.$Reactivo->clave}}" value="{{$option->clave}}"  onclick="optionWasClicked('{{$Reactivo->clave}}',[@foreach($Bloqueos as $b) @if($b->valor==$option->clave) '{{$b->bloqueado}}', @endif @endforeach ], [@foreach($Bloqueos as $b) '{{$b->bloqueado}}', @endforeach ]);">
  
{{$option->descripcion}} {{$Bloqueos->count()}}
@if($Bloqueos->where('valor',$option->clave)->count()>0)
pase a la {{$Bloqueos->where('valor',$option->clave)->last()->bloqueado}}
@endif
{{--{{$Bloqueos}}--}}
 </div>
<br>
@endforeach
