@extends('layouts.app')

@section('content')

<div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">AVISO DE PRIVACIDAD UNAM</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body text-justify">
El Programa de Vinculación con los Egresados y Académicos jubilados  de la Universidad Nacional Autónoma de México (UNAM), con domicilio en Zona Cultural de Ciudad Universitaria, Edificio D, planta baja, Alcaldía Coyoacán, C.P. 04510, en la Ciudad de México, es responsable del tratamiento de sus datos personales para el registro como egresado, difusión de información y generación de estadísticas para identificar, detectar e impulsar el desarrollo de oportunidades para los egresados de la UNAM.<br><br> No se realizarán transferencias de datos personales, salvo aquellas excepciones previstas por la Ley. Podrá ejercer sus derechos ARCO en  la Unidad de Transparencia de la UNAM, o a través de la Plataforma Nacional de Transparencia <br>(<a href='http://www.plataformadetransparencia.org.mx'>http://www.plataformadetransparencia.org.mx/</a>).<br><br>El aviso de privacidad integral se puede consultar en la sección Aviso de Privacidad de nuestro sitio web: <a href='https://www.pveaju.unam.mx/aviso-de-privacidad/'>https://www.pveaju.unam.mx/aviso-de-privacidad/</a>.
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
        </div>
        
      </div>
    </div>
  </div>

    <!--CABECERA/HEADER-->
    <div class="cabecera">
        <div class="logo">
            <a class="logoUNAM" href="https://www.unam.mx/"> <img src="/img/logos/logoUNAM-large-azul.png"> </a>

            <a class="logoUNAM" href="https://www.unam.mx/"> <img src="/img/logos/nuestra_unam.png"> </a>
        </div>

        <div class="subtitulo2 ">
            <a class="lovoPVE" href="https://www.pveaju.unam.mx/"> <img src="/img/logos/logoPVE-large.png" style="width:9vh;"> </a>
            <a class="lovoPVE" href="https://www.pveaju.unam.mx/"> <img src="/img/logos/Logo-40-color.png" style="width:9vh;"> </a>
        </div>
    </div>

    <!--INFORMACIÓN DE BIENVENIDA-->
<div class="main">
    
    <div class="izquierda">
        <h1>ENCUESTA DE EDUCACIÓN CONTINUA UNAM</h1>
    <div class="info">
        <p class="subtitulo3">
            TODAS LAS CARRERAS Y GENERACIONES
           
        </p>
        <br><br><br>
        <p class="texto2">
            Como parte de la campaña ReUNAMos Saberes, invitamos a nuestras y nuestros
egresados a participar en esta encuesta que busca fortalecer el vínculo con la
comunidad universitaria y enriquecer la oferta de educación continua.
Solicitamos su apoyo para responder el siguiente cuestionario, cuyos propósitos
son:
            <br><br>
            <ol>
                <li>
                    <span style="color: #e6af2b">Identificar</span>  las necesidades de formación y actualización profesional de los
egresados de la UNAM.
                </li>
                <li>
                     <span style="color: #e6af2b">Fortalecer </span> los programas de educación continua con base en los intereses y
obstáculos reales de la comunidad universitaria.
                </li>
                <li>
                    <span style="color: #e6af2b">Diseñar</span>  oportunidades de formación más accesibles y pertinentes para
mejorar la empleabilidad y el desarrollo profesional.
                </li>
            </ol>
            <br>
            Su participación es muy valiosa, ya que contribuirá a mejorar las oportunidades de
actualización y formación que ofrece nuestra Universidad.
        </p>
    </div>

        <!--CARDS PROPÓSITOS-->

    <div class="propositos">
        <!-- card 1 -->
             
        <div class="card-box">
            <p>
           Re<span class="amarillo">UNAM</span>os
            <span class="bigwhite"> Saberes</span> para
            <span class="bigwhite"> MANTENER VIVA</span> la
            <span class="amarillo"> CHISPA </span> del
            <span class="bigwhite">APRENDIZAJE</span> en nuestro dia a dia
        </div>
        <!-- card 2 -->
   
<div class="card-box">
            <p>
           La <span class="amarillo"> UNAM </span> 
            <span class="lilwhite"> genera conocimiento y </span>
            <span class="bigwhite"> EXPERIENCIAS </span> que mejoran y
            <span class="amarillo">TRANSFORMAN  </span>la vida del egresado
        </div>
        <!-- card 3 -->
  
<div class="card-box">
            <p>
            La <span class="amarillo">UNAM  </span> impulsa tu
            <span class="bigwhite">  CARRERA PROFESIONAL</span> con
            <span class="amarillo"> EDUCACIÓN CONTINUA</span> y
            <span class="bigwhite">APRENDIZAJE </span> profundo
        </div>




        
    </div>
    </div>


<div class="derecha">

        <!--CUADRO DE INICIAR ENCUESTA-->
    <div class="iniciar">
        <p class="texto4">
            <b>DURACIÓN APROXIMADA: 7 MINUTOS</b>
        </p>
        <br>
        <p class="texto4">
            PARA GENERACIONES QUE INGRESARON ANTES DE 1999 SE ANTEPONE UN <b>"0"</b> EN EL NÚMERO DE CUENTA
        </p>
        <br>

        <form action="{{ route('enc_continua.verify')}}" method="POST" enctype="multipart/form-data">
        @csrf
        
            <ul>
                
            @if(session('externo') == 'si')
                <li>
                    <label>Número de Cuenta:  </label>
                    <input type="number" id="numeroCuenta"   name="cuenta" readonly value="{{session('cuenta')}}" style="background-color:#CCC"  />
                </li>
                <li>
                    <label>Apellido Paterno:</label>
                    <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" name="paterno" required />
                </li>
                <li>
                    <label>Apellido Materno:</label>
                    <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();"   name="materno" />
                </li>
                <li>
                    <label>Nombre(s):</label>
                    <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" name="nombre" required />
                </li>
               <li>
                    <label>Plantel:</label> <br>
                     <select name="nbr3" id="nbr3" required >
                            <option value="" >Seleccione... </option> 

                            @foreach($Planteles as $option)
                            <option value="{{$option->clave_plantel}} " >{{$option->plantel}} </option> 

                            @endforeach
                            </select> 
                </li>
               <li>
                    <label>Carrera:</label> <br>
                   <select name="nbr2" id="nbr2" required >
                        <option value="" >Seleccione... </option> 
                        @foreach($Carreras as $option)
                        <option value="{{$option->clave}} " >{{$option->carrera}} </option> 
                        <br>
                        @endforeach
                    </select>
                </li>
               <li>
                    <label>Sexo:</label> <br>
                    <select name="sexo" id="" required >
                        <option value=""></option>
                        <option value="F">Femenino</option>
                        <option value="M">Maculino</option>
                    </select>
                </li>
                <li>
                    <label>Año de egreso:</label> <br>
                    <input type="number"  name="anio_egreso" min="1960" max="2027" required/>
                </li>
                
            @else
                <li>
                    <label>Número de Cuenta:  </label>
                    <input type="number" id="numeroCuenta"   name="cuenta" max="999999999"/>
                </li>
            @endif
                <li>
                    <button type="submit">Iniciar encuesta</button>
                </li>
            </ul>
        </form>
        <br>
        <p class="texto8">
            <b>Preferentemente utilizar Google Chrome</b>
        </p>
    </div>

</div>
</div>
<!--AVISO DE PRIVACIDAD-->
<div class="aviso">
    <p class="texto4">
            LA INFORMACIÓN QUE PROPORCIONE SERÁ ESTRICTAMENTE CONFIDENCIAL Y SÓLO SE UTILIZARÁ CON FINES ESTADÍSTICOS.
    </p>

    <div class="botonAviso">
        <p class="texto7">IMPORTANTE</p>
        <a href="https://www.pveaju.unam.mx/aviso-de-privacidad">Aviso de Privacidad</a>
    </div>
</div>
@endsection

@push('css')
<style>
    .swal2-popup {
    font-size: 14px !important;
}

.swal2-styled {
    padding: 10px 32px 10px 32px !important;
    margin: 20px 10px 0px 10px !important;
    width: 170px;
    height: 45px;
}
</style>
@endpush

@push('js')

@if (session('message') == 'realized')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
  icon: "success",
  title: "Encuesta realizada",
  text: "Parece que ya hemos capturado tus datos, gracias por participar en el estudio de seguimiento!",
  footer: '<a href="#">Why do I have this issue?</a>'
});
</script>
@endif

@if (session('externo') == 'si')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
  icon: "warning",
  title: "No tenemos tus datos en nuestros registros",
  html: "Por favor Ingresa a la encuesta general llenando todos tus datos, o bien registrate primero el la cedula de exalumno en: <a href='https://registro.pveaju.unam.mx/'>Obten tu cédula de egresado UNAM</a> ",
  footer: '<a href="https://registro.pveaju.unam.mx/">Obten tu cédula de egresado UNAM</a>'
});
</script>
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
@endif
<script>
    $(window).load(function(){
    $('#myModal').modal('show');
  })
</script>
</script>

 @endpush