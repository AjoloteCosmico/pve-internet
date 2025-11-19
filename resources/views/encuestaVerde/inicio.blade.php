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
El Programa de Vinculación con los Egresados y Académicos jubilados de la Universidad Nacional Autónoma de México (UNAM), con domicilio en Zona Cultural de Ciudad Universitaria, Edificio D, planta baja, Alcaldía Coyoacán, C.P. 04510, en la Ciudad de México, es responsable del tratamiento de sus datos personales para el registro como egresado, difusión de información y generación de estadísticas para identificar, detectar e impulsar el desarrollo de oportunidades para los egresados de la UNAM.<br><br> No se realizarán transferencias de datos personales, salvo aquellas excepciones previstas por la Ley. Podrá ejercer sus derechos ARCO en  la Unidad de Transparencia de la UNAM, o a través de la Plataforma Nacional de Transparencia <br>(<a href='http://www.plataformadetransparencia.org.mx'>http://www.plataformadetransparencia.org.mx/</a>).<br><br>El aviso de privacidad integral se puede consultar en la sección Aviso de Privacidad de nuestro sitio web: <a href='https://www.pveaju.unam.mx/aviso-de-privacidad/'>https://www.pveaju.unam.mx/aviso-de-privacidad/</a>.
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
        </div>
        
      </div>
    </div>
  </div>
   


<div class="container-fluid fondo-container">

  <!-- LADO IZQUIERDO -->
  <div class="izquierda">
    <img src="{{ asset('img/verde/header.png') }}" alt="Header" class="header-img" >
    <br> <br>
    <img src="{{ asset('img/verde/empleabilidad.png') }}" alt="Empleabilidad Verde" class="emp-img">
   
    <img src="{{ asset('img/verde/leyenda.png') }}" alt="Empleabilidad Verde" class="fondo-img">
    
  </div>

  <!-- LADO DERECHO CON HOJAS -->
  <div class="derecha">
    <div class="formulario">
      <form action="{{ route('enc_verde.verify')}}" method="POST" enctype="multipart/form-data">
          @csrf
        <div class="form-group">
          <label for="cuenta" style="color:#96d877ff;  font-size: 4.1 vh;">Número de Cuenta:</label>
          <input  class="form-control"  type="number" id="numeroCuenta"   name="cuenta" max="999999999">
        </div>
     
        <button type="submit" class="btn btn-warning btn-block w-5">Iniciar</button>
      </form>
    </div>
  </div>


</div>

<div class="footer">
  <div class="footer-content container text-center">

    <!-- Texto superior -->
    <p class="footer-intro">
      <strong>Egresados UNAM:</strong><br>
      La Encuesta <span class="destacado">Egresados UNAM: Empleabilidad Verde</span> busca
      conocer el impacto de la inserción laboral de los egresados
      en el ámbito profesional enfocado o relacionado con el denominado
      <span class="destacado">empleo verde</span>.
    </p>
    </div>
  </div>
  <div class="footer-white">
    <div class="footer-content container text-center">
    <!-- Subtítulo -->
     <br><br>
    <p class="footer-subtitulo">
      En cumplimiento del Eje transversal<br>
      <span class="sustentabilidad">SUSTENTABILIDAD</span>, la UNAM
    </p>

    <!-- Recuadros azules -->
    <div class="footer-cards d-flex justify-content-center">
      <img src="{{ asset('img/verde/cuadro1.png') }}" alt="Forma" class="footer-card">
      <img src="{{ asset('img/verde/cuadro2.png') }}" alt="Fortalece" class="footer-card">
      <img src="{{ asset('img/verde/cuadro3.png') }}" alt="Impulsa" class="footer-card">
    </div>

    <!-- Texto inferior -->
    <p class="footer-nota">
      La información que proporcione será estrictamente confidencial y sólo se utilizará con fines estadísticos.<br>
      <span class="importante">IMPORTANTE</span>
      <a href="https://www.pveaju.unam.mx/aviso-de-privacidad/" target="_blank" class="aviso">Aviso de Privacidad</a>
    </p>
    <br>
    <br><br><br>
  </div>
</div>


@endsection

@push('css')
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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
  <style>
    body {
      margin: 0 !important;
      padding: 0 !important;
      background-color: #f0f0f0;
    }

    .fondo-container {
      display: flex;
      flex-wrap: wrap;
      min-height: 80vh;
      width: 100% !important;
      background: #fff;
      z-index: 10;
    }

    /* LADO IZQUIERDO */
    .izquierda {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: left;
      align-items: left;
      padding: 3vw 9vw 4vh 9vw;
      background: #fff;
    }

    .fondo-img {
      max-width: 100%;
      height: auto;
      margin-bottom: 20px;
    }

    .emp-img {
      /* height: 48%; */
      /* width: auto !important; */
    }
    .header-img {
      max-width: 100%;
      height: auto;
    }
    /* LADO DERECHO CON FONDO DE HOJAS */
    .derecha {
      flex: 1;
      position: relative;
      background: url('{{ asset('img/verde/hojas.png') }}') no-repeat center center;
      background-size: cover;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      z-index: 10;
    }

   
    /* FORM ENCIMA DEL FONDO */
    .formulario {
      background: rgba(15, 15, 245, 0.8);
      padding: 20px;
      border-radius: 18px;
      font-color: #96d877ff;
    
      width: 100%;
      max-width: 350px;
      position: relative;
      display: flex;
      justify-content: center;
      
      z-index: 10; /* se asegura de estar encima del fondo */
    }
/* pie de pagina */
  .footer {
      width: 100%;
      background-color: #91b400; /* verde */
      padding: 0vh,0vh,0vh,0vh;
      color: #fff;;
      position: relative;
      
      margin-top: -12vh; /* hace que se meta un poco sobre el footer */
      z-index: 1;
    }

    .footer-intro {
      font-size: 2.5rem;
      line-height: 1.5;
      color: #fff;
    }
    .footer-white{
      width: 100vw !important;
      background-color: #fff; /* verde */
    
    }

    .footer-intro .destacado {
      color: #004c97; /* azul fuerte */
      font-weight: bold;
    }

    .footer-subtitulo {
      margin-top: 25px;
      font-size: 2.2rem;
      color: #333;
      font-weight: 500;
    }

    .footer-subtitulo .sustentabilidad {
      color: #91b400;
      font-weight: bold;
    }

    .footer-cards {
      margin: 30px auto;
      gap: 20px;
      flex-wrap: wrap;
    }

    .footer-card {
      max-width: 200px;
      height: auto;
    }

    .footer-nota {
      font-size: 1.85rem;
      color: #666;
    }

    .footer-nota .importante {
      color: #91b400;
      font-weight: bold;
    }

    .footer-nota .aviso {
      margin-left: 10px;
      color: #004c97;
      text-decoration: underline;
    }

    /* Layout vertical en pantallas pequeñas */
    @media (max-width: 991px) {
      .fondo-container {
        flex-direction: column;
      }
      .izquierda, .derecha {
        flex: none;
        width: 100%;
        min-height: 50vh;
      }
      .formulario {
        margin-top: 20px;
      }
    }
  </style>
@endpush

@push('js')

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@if (session('message') == 'no_data')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
  icon: "error",
  title: "Oops...",
  text: "No encontramos tu numero de cuenta, tal vez no perteneces a las generacion 2020, revisa que tu numero de cuenta halla sido escrito correctamente!",
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
    $(window).on("load",function(){
        $('#myModal').modal('show');
    });
</script>
 @endpush