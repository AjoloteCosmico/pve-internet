<script>
var ncorreos="{{$Correos->count()+1}}";
var ntel="{{$Telefonos->count()+1}}";

function add_correo(){
    console.log('ejecutando funcion');
    
    console.log(ncorreos);
    const div = document.getElementById("correosDiv");

    div.innerHTML += `<input type="email" class="form-control" value="" name="correos[`+ncorreos+`]"> `;
    ncorreos=String( parseInt(ncorreos)+1);
}
function add_tel(){
    console.log('ejecutando funcion');
    console.log(ntel);
    const div = document.getElementById("telefonosDiv");
    div.innerHTML += `<input type="text" class="form-control"  value="" name="telefonos[`+ntel+`]" id="telefonos[`+ntel+`]" onkeyup="validate_phone(`+ntel+`)"> <p class="warning-label" id="warnlab[`+ntel+`]"> Ingresa almenos 10 digitos </p>`;
    ntel=String( parseInt(ntel)+1);
}
function countDigits( str ) {
  var acu = 0;

  Array.prototype.forEach.call( str, function( val ) {
    acu += ( val.charCodeAt( 0 ) > 47 ) && ( val.charCodeAt( 0 ) < 58 ) ? 1 : 0;
  } );

  return acu;
}

function validate_phone(count_tel){
console.log(count_tel);
val=document.getElementsByName('telefonos['+count_tel+']')[0].value;
console.log('hay '+ countDigits(val)+' digitos en el tel ' +count_tel);
if(countDigits(val)<10){
    document.getElementById('warnlab['+count_tel+']').classList.add("active-warn");
    document.getElementsByName('telefonos['+count_tel+']')[0].classList.add("error");
    document.getElementById('final-button').disabled=true;

}else{
    document.getElementById('warnlab['+count_tel+']').classList.remove("active-warn");
    document.getElementsByName('telefonos['+count_tel+']')[0].classList.remove("error");
    document.getElementById('final-button').disabled=false;
}

}

</script>