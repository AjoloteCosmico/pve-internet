<!--
<select name="{{$Reactivo->clave}}" id="{{'select-'.$Reactivo->clave}}" onchange="optionWasSelected('{{$Reactivo->clave}}',[@foreach($Bloqueos->unique('bloqueado') as $b) '{{$b->bloqueado}}', @endforeach ])">
<option value="" >Seleccione... </option> 

@foreach($Opciones->sortBy('orden') as $option)

 <option value="{{$option->clave}}" title="{{$option->help_info}}"> {{$option->descripcion}} </option> 

<br>
@endforeach
</select>
-->




<!--
JALA PERO HAY PRTOBLEMAS CUANDO BAJAAAAA
<select name="{{$Reactivo->clave}}" id="{{'select-'.$Reactivo->clave}}" onchange="optionWasSelected('{{$Reactivo->clave}}',[@foreach($Bloqueos->unique('bloqueado') as $b) '{{$b->bloqueado}}', @endforeach ]); updateTooltip('{{$Reactivo->clave}}')">
<option value="" >Seleccione... </option> 

@foreach($Opciones->sortBy('orden') as $option)

 <option value="{{$option->clave}}" data-help="{{$option->help_info}}"> {{$option->descripcion}} </option> 

<br>
@endforeach
</select>

//Contenedor para mostrar el "tooltip" dinámico con ícono 
<div id="tooltip-{{$Reactivo->clave}}" style="margin-top: 8px; font-size: 1.1em; color: #263EB5;">
    <i class="fa fa-info-circle" aria-hidden="true" style="font-size: 1.3em; margin-right: 8px; color: #002B7A;"></i>
    <span id="tooltip-text-{{$Reactivo->clave}}"></span>
</div>

// Script para actualizar la descripción al seleccionar una opción 
<script>
function updateTooltip(reactivoClave) {
    const select = document.getElementById('select-' + reactivoClave);
    const tooltipText = document.getElementById('tooltip-text-' + reactivoClave);
    const selectedOption = select.options[select.selectedIndex];
    const helpText = selectedOption.getAttribute('data-help') || '';
    tooltipText.innerText = helpText;
}
</script>
-->

<div class="custom-select">
    <div class="select-header" onclick="toggleSelect('{{ 'select-' . $Reactivo->clave }}')">
        <span class="selected-value">Seleccione...</span>
    </div>
    <div class="select-options" id="{{ 'select-' . $Reactivo->clave }}">
        @foreach($Opciones->sortBy('orden') as $option)
        <div 
            class="option-item" 
            onmouseover="showMessage('{{ $option->help_info }}')" 
            onclick="optionWasSelected('{{ $Reactivo->clave }}', '{{ $option->clave }}')"
            data-bloqueos='[@foreach($Bloqueos->unique("bloqueado") as $b) "{{ $b->bloqueado }}", @endforeach]'
        >
            {{$option->descripcion}}
            <div class="option-description">{{$option->help_info}}</div>
        </div>
        @endforeach
    </div>
</div>
<script>
    function showMessage(message) {
        console.log(message); // Muestra el mensaje en la consola
    }

    function optionWasSelected(reactivoClave, optionClave) {
        console.log(`Opción seleccionada: Reactivo ${reactivoClave}, Opción ${optionClave}`);
        // Aquí puedes agregar lógica adicional para manejar los bloqueos
    }
</script>









