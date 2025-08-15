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
El Programa de Vinculación con los Egresados de la Universidad Nacional Autónoma de México (UNAM), con domicilio en Zona Cultural de Ciudad Universitaria, Edificio D, planta baja, Alcaldía Coyoacán, C.P. 04510, en la Ciudad de México, es responsable del tratamiento de sus datos personales para el registro como egresado, difusión de información y generación de estadísticas para identificar, detectar e impulsar el desarrollo de oportunidades para los egresados de la UNAM.<br><br> No se realizarán transferencias de datos personales, salvo aquellas excepciones previstas por la Ley. Podrá ejercer sus derechos ARCO en  la Unidad de Transparencia de la UNAM, o a través de la Plataforma Nacional de Transparencia <br>(<a href='http://www.plataformadetransparencia.org.mx'>http://www.plataformadetransparencia.org.mx/</a>).<br><br>El aviso de privacidad integral se puede consultar en la sección Aviso de Privacidad de nuestro sitio web: <a href='http://www.pveaju.unam.mx/avisodeprivacidad'>http://www.pveaju.unam.mx/avisodeprivacidad</a>.
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
            <a class=logoUNAM href="https://www.unam.mx/"> <img src="/img/logos/logoUNAM-large-azul.png"> </a>

            <a class=lovoPVE href="https://www.pveaju.unam.mx/"> <img src="/img/logos/logoPVE-large.png"> </a>
        </div>

        <div class="subtitulo2 ">
            <p>Secretaría General</p>
        </div>
    </div>

    <!--INFORMACIÓN DE BIENVENIDA-->
<div class="main">
    <div class="izquierda">
    <div class="info">
        <p class="subtitulo3">
            @if($type=='general')
            TODAS LAS CARRERAS Y GENERACIONES
            @else
            Generación de egreso 2016
            @endif
           
        </p>
        <br><br><br>
        <p class="texto2">
            Solicitamos su apoyo para contestar el siguiente cuestionario que tiene como propósito conocer:
            <br><br>
            <ol>
                <li>
                    Su <span style="color: #e6af2b">opinión</span> sobre los beneficios que ha obtenido con su formación profesional
                </li>
                <li>
                    Sus <span style="color: #e6af2b">expectativas</span> al incorporarse al campo ocupacional de su profesión
                </li>
                <li>
                    Su grado de <span style="color: #e6af2b">satisfacción</span> con la preparación que recibió en la UNAM
                </li>
            </ol>
        </p>
    </div>

        <!--CARDS PROPÓSITOS-->

    <div class="propositos">
        <img class="card" src="/img/gráficos/pag-encuesta-1.png">

        <img class="card" src="/img/gráficos/pag-encuesta-2.png">

        <img class="card" src="/img/gráficos/pag-encuesta-3.png">
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

        <form action="{{ route('enc16.verify')}}" method="POST" enctype="multipart/form-data">
        @csrf
            <input type="hidden" name="type" value="{{$type}}">
            <ul>
                <li>
                    <label>Número de Cuenta:</label>
                    <input type="number" id="numeroCuenta"   name="cuenta" max="999999999"/>
                </li>

                @if($type=='general')
                
                <li>
                    <label>Apellido Paterno:</label>
                    <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" name="paterno"/>
                </li>
                <li>
                    <label>Apellido Materno:</label>
                    <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();"   name="materno"/>
                </li>
                <li>
                    <label>Nombre(s):</label>
                    <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" name="nombre"/>
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
        <a href="https://www.pveaju.unam.mx/aviso-de-privacidad.php">Aviso de Privacidad</a>
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
@if (session('message') == 'no_data')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
  icon: "error",
  title: "Oops...",
  text: "No encontramos tu número de cuenta, tal vez no perteneces a las generacion 2016, revisa que tu número de cuenta halla sido escrito correctamente!",
  footer: '<a href="#">Why do I have this issue?</a>'
});
</script>
@endif
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

@if (session('message') == 'notinsample')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
  icon: "warning",
  title: "Parece que no es tu generacion",
  text: "Por favor Ingresa a la encuesta general llenando todos tus datos",
  footer: '<a href="#">Why do I have this issue?</a>'
});
</script>
@endif
<script>
    $(window).load(function(){
    $('#myModal').modal('show');
  })
</script>
</script>

 @endpush