

<div class="form-group">
    <label for="exampleFormControlInput1">Plantel</label>
                    
    <select name="nbr3" id="nbr3" >
    <option value="" >Seleccione... </option> 

    @foreach($Planteles as $option)
    <option value="{{$option->clave_plantel}} " >{{$option->plantel}} </option> 

    @endforeach
    </select> 
</div>
<div class="form-group">
    <label for="exampleFormControlInput1">Carrera</label>
                  
    <select name="nbr2" id="nbr2" >
    <option value="" >Seleccione... </option> 
    @foreach($Carreras as $option)
    <option value="{{$option->clave}} " >{{$option->carrera}} </option> 
    <br>
    @endforeach
    </select>
</div>
<div class="form-group">
    <label for="exampleFormControlInput1">Año en que ingresó</label>
    <input type="number"  name="anio_ingreso">
</div>

<div class="form-group">
    <label for="exampleFormControlInput1">Año en que Egresó</label>
    <input type="number"  name="anio_egreso">

</div>
                  
@push('js')
<script>
function removeOptions(selectElement) {
   var i, L = selectElement.options.length - 1;
   for(i = L; i >= 0; i--) {
      selectElement.remove(i);
   }
}

function set_carreras(seleccionado){
    console.log('entrando a la funcion');
        console.log(seleccionado)
removeOptions(document.getElementById('nbr2'));
var desc = document.getElementById("nbr2");
@foreach($Planteles as $p)
if(seleccionado=={{$p->clave_plantel}}){
    var example_array = {
        @foreach($Carreras as $carrera)
        @if($carrera->clave_plantel==$p->clave_plantel)
    {{$carrera->clave_carrera}} : '{{$carrera->carrera}}',
         @endif
    @endforeach
};
}
@endforeach
console.log(example_array);
for(index in example_array) {
    desc.options[desc.options.length] = new Option(example_array[index], index);
}
}

$(document).ready(function () {     
  $('#nbr3').change(function(){
        var seleccionado = $(this).val();
        set_carreras(seleccionado);
        
  });
  });
  var seleccionado = document.getElementById('nbr3').value;
  set_carreras(seleccionado);
  </script>
@endpush