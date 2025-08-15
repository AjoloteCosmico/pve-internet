<!--
<select name="{{$Reactivo->clave}}" id="{{'select-'.$Reactivo->clave}}" onchange="optionWasSelected('{{$Reactivo->clave}}',[@foreach($Bloqueos->unique('bloqueado') as $b) '{{$b->bloqueado}}', @endforeach ])">
<option value="" >Seleccione... </option> 

@foreach($Opciones->sortBy('orden') as $option)

 <option value="{{$option->clave}}" title="{{$option->help_info}}"> {{$option->descripcion}} </option> 
<br>
@endforeach
</select>
-->

{{--<div class="custom-select">
    <div class="select-header" onclick="toggleSelect('{{ 'select-' . $Reactivo->clave }}')">
        <span class="selected-value">Seleccione...</span>
    </div>
    <div class="select-options" id="{{ 'select-' . $Reactivo->clave }}">
        @foreach($Opciones->sortBy('orden') as $option)
        <div 
            class="option-item"
            data-valor="{{$option->clave}}"
            onmouseover="showMessage('{{ $option->help_info }}')" 

            onclick="optionWasSelected('{{$Reactivo->clave}}', [@foreach($Bloqueos->unique('bloqueado') as $b) '{{$b->bloqueado}}', @endforeach], '{{$option->clave}}');"
            data-bloqueos='[@foreach($Bloqueos->unique("bloqueado") as $b) "{{ $b->bloqueado }}", @endforeach]'
        >
            {{$option->descripcion}}
            <div class="option-description">{{$option->help_info}}</div>
        </div>
        @endforeach

        <input type="hidden" name="{{ $Reactivo->clave }}" id="input-{{ $Reactivo->clave }}" value="">
    </div>
</div> --}}


<div class="custom-select" >
        <select id="real-select{{$Reactivo->clave}}" style="display: none;">
             @foreach($Opciones->sortBy('orden') as $option)
            <option value="{{$option->clave}}" data-desc="{{$option->help_info}}" >{{$option->descripcion}}</option>
            @endforeach
        </select>
        
        <div class="select-header" onclick="change_styles()" >
            <span class="selected-value{{$Reactivo->clave}}">Selecciona tu puesto</span>
        </div>
        
        <div class="select-options" id="selectOptions{{$Reactivo->clave}}">
            <!-- Las opciones se generan dinámicamente -->
        </div>
    </div>
<!-- 
<script>
    function showMessage(message) {
        console.log(message); // Muestra el mensaje en la consola
    }
</script>
 -->











