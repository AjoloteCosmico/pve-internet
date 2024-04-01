 <h3 id="{{$Reactivo->clave.'-redact'}}" @if($Reactivo->child==1) style="  font-size: 1.2vw;" @endif>{{$Reactivo->description}}</h3>

<input type="number"  onfocus="showlabel('{{$Reactivo->clave.'label'}}')" onchange="unblockNext('{{$Reactivo->clave}}')" name="{{$Reactivo->clave}}">
<label class="input-label" id="{{$Reactivo->clave.'label'}}">Presiona Enter  </label> 