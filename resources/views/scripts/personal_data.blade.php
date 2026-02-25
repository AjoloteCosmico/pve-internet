<script>
@isset($Correos)
var ncorreos="{{$Correos->count()+1}}";
var ntel="{{$Telefonos->count()+1}}";
@endisset


function add_correo(){
    console.log('ejecutando funcion');
    
    console.log(ncorreos);
    const div = document.getElementById("correosDiv");

    div.innerHTML += `<input type="email" class="form-control" value="" name="correos[`+ncorreos+`]" onblur="validate_correo(`+ncorreos+`)"> `;
    ncorreos=String( parseInt(ncorreos)+1);
}

function add_tel(){
    console.log('ejecutando funcion');
    console.log(ntel);
    const div = document.getElementById("telefonosDiv");
    div.innerHTML += `<input type="text" class="form-control myinput"  value="" name="telefonos[`+ntel+`]" id="telefonos[`+ntel+`]" onkeyup="validate_phone(`+ntel+`)" placeholder="Ingresa un numero actualizado"> <p class="warning-label" id="warnlab[`+ntel+`]"> Ingresa almenos 10 digitos </p>`;
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
const inputElement = document.getElementsByName('telefonos['+count_tel+']')[0];
const warnlab = document.getElementById('warnlab['+count_tel+']');


const isEmpty = val.trim().length === 0;
const isLengthError = countDigits(val) < 10 && val.length > 0;
const isDuplicate = isDuplicateInForm('telefonos', val, inputElement);


console.log('hay '+ countDigits(val)+' digitos en el tel ' +count_tel);


if (isLengthError || isDuplicate){
    if(isDuplicate){
        warnlab.innerText = ' Advertencia: El número ' + val + ' está duplicado en este formulario.';
      } else if (isLengthError){
        warnlab.innerText = ' Ingresa al menos 10 dígitos ';
      }

      warnlab.classList.add("active-warn");
      inputElement.classList.add("error");
      document.getElementById('final-button').disabled=true;
} else {
    warnlab.classList.remove("active-warn");
    inputElement.classList.remove("error");
    document.getElementById('final-button').disabled=false;

  
@if(isset($Egresado))
    @if($Egresado->fuente=='internet')
      plan=document.getElementById('select_plan').value;
      programa=document.getElementById('select_programa').value;
      grado=document.getElementById('select_grado').value;
      anio=document.getElementById('anio').value;
      document.getElementById('final-button').disabled=true;
      if(plan!="" && programa!="" && grado!=""&& anio!=""){
          document.getElementById('final-button').disabled=false;
      }
    @endif @endif

}

}

//Funcion de Validar Correos

function validate_correo(count_correo){
  const inputElement = document.getElementsByName('correos[' + count_correo + ']')[0];
  const val = inputElement.value;
  const isDuplicate = isDuplicateInForm('correos', val, inputElement);

  if (isDuplicate && val.length > 0) {
    inputElement.classList.add("error");
    swal.fire({
      icon: 'warning',
      title: 'Correo duplicado',
      text: 'El correo ' + val + ' está duplicado en este formulario.',
    });
  } else {
    inputElement.classList.remove("error");
  }
}

@if(isset($Egresado))
@if($Egresado->fuente=='internet')
function checkNotNa(sel) {
    if (sel.value==""){
        document.getElementById('final-button').disabled=true;
    }else{
      plan=document.getElementById('select_plan').value;
      programa=document.getElementById('select_programa').value;
      grado=document.getElementById('select_grado').value;
      anio=document.getElementById('anio').value;
      if(plan!="" && programa!="" && grado!=""&& anio!=""){
          document.getElementById('final-button').disabled=false;
      }
    }
  }
plan=document.getElementById('select_plan').value;
programa=document.getElementById('select_programa').value;
grado=document.getElementById('select_grado').value;
anio=document.getElementById('anio').value;
document.getElementById('final-button').disabled=true;
if(plan!="" && programa!="" && grado!=""&& anio!=""){
          document.getElementById('final-button').disabled=false;
      }
@endif
@endif


//Funcion para validar duplicados 
function isDuplicateInForm(namePrefix, currentValue, currentElement){
  if (!currentValue || currentValue.trim() === '') {
    return false; // ignoramos campos vacios
  }
  const inputs = document.querySelectorAll(`input[name^="${namePrefix}["]`);

  const cleanedCurrentValue = currentValue.trim().toLowerCase().replace(/[^a-z0-9@.]/g, '');

  for (let i=0; i< inputs.length; i++){
    const input = inputs[i];
    if (input === currentElement) continue;

    const otherValue = input.value.trim().toLowerCase().replace(/[^a-z0-9@.]/g, '');

    if (otherValue === cleanedCurrentValue){
      return true;
    }
  }
  return false;

}

</script>