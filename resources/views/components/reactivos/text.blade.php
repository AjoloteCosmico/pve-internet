
<label class="input-label" id="{{$Reactivo->clave.'label'}}">Presiona Enter</label>

<input onfocus="showlabel('{{$Reactivo->clave.'label'}}')" onchange="unblockNext('{{$Reactivo->clave}}')" type="text" name="{{$Reactivo->clave}}">
<br>