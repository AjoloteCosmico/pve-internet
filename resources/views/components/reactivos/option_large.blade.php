{{--
<select name="{{$Reactivo->clave}}" id="{{'select-'.$Reactivo->clave}}" onchange="optionWasSelected('{{$Reactivo->clave}}',[@foreach($Bloqueos->unique('bloqueado') as $b) '{{$b->bloqueado}}', @endforeach ])">
<option value="" >Seleccione... </option> 

@foreach($Opciones->sortBy('orden') as $option)

 <option value="{{$option->clave}}" title="{{$option->help_info}}"> {{$option->descripcion}} </option> 
<br>
@endforeach
</select>
--}}


<div class="custom-select">
    <div class="select-header" onclick="toggleSelect('{{ 'select-' . $Reactivo->clave }}')">
        <span class="selected-value">Seleccione...</span>
    </div>
    <div class="select-options" id="{{ 'select-' . $Reactivo->clave }}" style="display: none;">
        @foreach($Opciones->sortBy('orden') as $option)
        <div 
            class="option-item {{'op-container-'.$Reactivo->clave}}"
            data-valor="{{$option->clave}}"
            id="{{ $Reactivo->clave.'cont-option-'.$option->clave }}"
            onclick="optionWasSelected('{{$Reactivo->clave}}', [@foreach($Bloqueos->unique('bloqueado') as $b) '{{$b->bloqueado}}', @endforeach],'{{$Reactivo->update_rules}}',[{{$option->update_rules}}]);"
            @if($option->help_info)
                onmouseover="showMessage('{{ $option->help_info }}')" 
                data-tippy-size="jumbo"
                data-tippy-content="{{$option->help_info}}" 
                
            @endif()
            data-bloqueos='[@foreach($Bloqueos->unique("bloqueado") as $b) "{{ $b->bloqueado }}", @endforeach]'
            >
            {{$option->descripcion}}
            <div class="option-description">{{$option->help_info}}</div>
        </div>
        @endforeach
        <input type="hidden" name="{{ $Reactivo->clave }}" id="input-{{ $Reactivo->clave }}" value="">
    </div>
</div>

<script>
    function toggleSelect(selectId) {
        const selectOptions = document.getElementById(selectId);
        if (selectOptions) {
            // Cerrar otros selects abiertos
            document.querySelectorAll('.select-options').forEach(opt => {
                if (opt.id !== selectId) {
                    opt.style.display = 'none';
                }
            });
            // Toggle del select actual
            selectOptions.style.display = selectOptions.style.display === 'none' ? 'block' : 'none';
        }
    }

    function showMessage(message) {
        console.log(message);
    }

    // Cerrar select cuando se haga clic fuera
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.custom-select')) {
            document.querySelectorAll('.select-options').forEach(opt => {
                opt.style.display = 'none';
            });
        }
    });
</script>












