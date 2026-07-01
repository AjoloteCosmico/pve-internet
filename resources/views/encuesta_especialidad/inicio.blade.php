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
            &nbsp;&nbsp;
            <a class=lovoPVE href="https://posgrado.derecho.unam.mx/"> <img src="{{url('img/logos/escudo_derecho.png')}}" style="height: 6vh !important; width:auto !important"> </a>
      
        </div>
    </div>

    <!--INFORMACIÓN DE BIENVENIDA-->
<div class="main">
    
    <div class="izquierda">
        <h1>ENCUESTA PARA EGRESADOS DE ESPECIALIDADES UNAM</h1>
    <div class="info">
        <p class="subtitulo3">
            GENERACIONES 2020 - 2024
           
        </p>
        <br><br>
        <p style="font-size: 24px;">Estimado(a) egresado(a):</p>
        <br>
        <p class="texto2" style="text-align: justify">
           
Con el compromiso de mantener y fortalecer la calidad de nuestros programas académicos, le invitamos a participar en la Encuesta de Seguimiento de Egresados del Programa Único de Especialidad en Derecho. Este instrumento tiene como objetivo conocer su trayectoria profesional, evaluar el impacto de la formación recibida y detectar áreas de oportunidad que contribuyan a la mejora continua con respecto a la Especialidad que cursó.
Su participación es fundamental para que nuestra institución continúe ofreciendo una educación de calidad, acorde con las demandas del entorno laboral y social. La información que proporciones será tratada de manera confidencial y se utilizará exclusivamente con fines académicos y estadísticos.
<br>
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

        <form action="{{ route('enc_esp.verify')}}" method="POST" enctype="multipart/form-data">
        @csrf
            <ul>
    
                <li>
                    <label>Número de Cuenta:  </label>
                    <input type="number" id="numeroCuenta"   name="cuenta"  max="999999999"  />
                </li>
                    <br>
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

@if (session('message') == 'notinsample')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
  icon: "warning",
  title: "Parece que no es tu generacion",
  html: "No tenemos registrado tu número de cuenta como un egresado de especialidad UNAM para las generaciones del estudio, si lo deseas, puedes contestar la encuesta para todas las carreras y generaciones en el siguiente enlace: <br> <a href='https://encuestas.pveaju.unam.mx/encuesta_generacion/general'>Encuesta de egresados UNAM</a>",
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