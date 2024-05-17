
<div class="container" style="width: 45vmax">
@foreach($Opciones as $o)

    <div class="row">
        <div class="col">
        <input type="checkbox" id="{{$Reactivo->clave.'op'.$o->clave}}" class="{{$Reactivo->clave}}opcion" name="{{$Reactivo->clave}}opcion{{$o->clave}}" onclick="optionChecked('{{$Reactivo->clave}}','{{$o->clave}}', [ @foreach($Bloqueos->where('valor',$o->clave) as $b) '{{$b->bloqueado}}', @endforeach ] )" />
        <label>{{$o->descripcion}}</label>
        </div>
    </div>

@endforeach

<br>
<label class="input-label" id="{{$Reactivo->clave.'label'}}" onclick="siguiente('{{$Reactivo->clave}}')">Listo</label>

</div>

