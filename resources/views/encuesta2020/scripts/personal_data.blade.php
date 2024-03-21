<script>
var ncorreos="{{$Correos->count()}}";
var ntel="{{$Telefonos->count()}}";

function add_correo(){
    console.log('ejecutando funcion');
    
    console.log(ncorreos);
    const div = document.getElementById("correosDiv");

    div.innerHTML += `<input type="text" class="form-control" value="" name="correos[`+ncorreos+`]"> `;
    ncorreos=String( parseInt(ncorreos)+1);
}
function add_tel(){
    console.log('ejecutando funcion');
    
    console.log(ntel);
    const div = document.getElementById("telefonosDiv");

    div.innerHTML += `<input type="text" class="form-control"  value="" name="telefonos[`+ntel+`]"> `;
    ntel=String( parseInt(ntel)+1);
}

</script>