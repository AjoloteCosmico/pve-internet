
<div class="container" name="{{$Reactivo->clave}}" style="width: 90%">
<p style="font-size:1.3em">Seleccione una o varias opciones</p>
<br>
@foreach($Opciones->sortBy('orden')  as $o)

   
            <div class="row" style="flex-wrap: nowrap; overflow-x: auto;">
                <input type="checkbox" 
                   id="{{$Reactivo->clave.'op'.$o->clave}}" 
                   data-clave="{{$o->clave}}"
                   class="{{$Reactivo->clave}}opcion" 
                   name="{{$Reactivo->clave}}opcion{{$o->clave}}" 
                   onclick="optionChecked('{{$Reactivo->clave}}','{{$o->clave}}', [ @foreach($Bloqueos->where('valor',$o->clave)->where('clave_reactivo',$Reactivo->clave) as $b) '{{$b->bloqueado}}', @endforeach ] )"
                   @if($o->help_info)
                        data-tippy-size="jumbo"
                        data-tippy-content="{{$o->help_info}}" 
                    @endif()
                   /> 
                    <label data-tippy-size="jumbo" style="font-size:1.3em"
                   @if($o->help_info)
                        data-tippy-content="{{$o->help_info}}" 
                    @endif()>
                        {{$o->descripcion}}
                    </label>
            </div>
           
@endforeach

<br>
<button class="input-label" type="button" id="{{$Reactivo->clave.'label'}}" onclick="find_next('{{$Reactivo->clave}}')" disabled>Listo</button>

</div>

