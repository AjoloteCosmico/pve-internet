<div class="stars-row-wrapper">
@foreach($Opciones->sortBy('orden') as $option)

@php $size = 25 + ($loop->index * 7); @endphp

<div id="{{'cuadrito'.$Reactivo->clave.$option->clave}}"
     data-tippy-size="jumbo"
     @if($option->help_info)
          data-tippy-content="{{$option->help_info}}"
     @endif()
     class="{{'cuadrito-'.$Reactivo->clave}} star-option"
     style="display: inline-flex; flex-direction: column; align-items: center; gap: 4px; cursor: pointer; margin: 0 4px; vertical-align: bottom;"
     onclick="optionWasClicked('{{$Reactivo->clave}}',[@foreach($Bloqueos as $b) @if($b->valor==$option->clave) '{{$b->bloqueado}}', @endif @endforeach ], [@foreach($Bloqueos->unique('bloqueado') as $b) '{{$b->bloqueado}}', @endforeach ],'{{$option->clave}}');">

     {{-- Estrella SVG --}}
     <svg class="star-svg" width="{{$size + 4}}" height="{{$size + 4}}" viewBox="0 0 {{$size + 4}} {{$size + 4}}" style="display:block;">
          <path class="star-shape" style="transition: fill 0.2s, stroke 0.2s; fill: #ffffff; stroke: #002B7A; stroke-width: 1.5;"
               d="{{-- el path se genera con JS abajo, usamos un placeholder --}}"/>
     </svg>

     {{-- Label opcional: número o descripción corta --}}
     <span class="star-label" style="font-size: 11px; color: inherit; pointer-events: none;">{{$option->descripcion}}</span>

     {{-- Input radio oculto — mismo comportamiento que antes --}}
     <input type="radio"
          id="{{$Reactivo->clave.'op'.$option->clave}}"
          name="{{$Reactivo->clave}}"
          class="{{'op'.$Reactivo->clave}}"
          value="{{$option->clave}}"
          style="display: none;"
          onclick="optionWasClicked('{{$Reactivo->clave}}',[@foreach($Bloqueos as $b) @if($b->valor==$option->clave) '{{$b->bloqueado}}', @endif @endforeach ], [@foreach($Bloqueos->unique('bloqueado') as $b) '{{$b->bloqueado}}', @endforeach ],'{{$option->clave}}');">
</div>

@endforeach
</div>