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
   


<div class="container-fluid fondo-container">

  <!-- LADO IZQUIERDO -->
  <div class="izquierda">
    <img src="{{ asset('img/verde/header.png') }}" alt="Header" class="fondo-img" >
    <br> <br>
    <img src="{{ asset('img/verde/empleabilidad.png') }}" alt="Empleabilidad Verde" class="fondo-img">
   
   
    <img src="{{ asset('img/verde/leyenda.png') }}" alt="Empleabilidad Verde" class="fondo-img">
    
  </div>

  <!-- LADO DERECHO CON HOJAS -->
  <div class="derecha">
    <div class="formulario">
      <form action="{{ route('enc_verde.verify')}}" method="POST" enctype="multipart/form-data">
          @csrf
        <div class="form-group">
          <label for="cuenta" style="color:#96d877ff">Número de Cuenta:</label>
          <input  class="form-control"  type="number" id="numeroCuenta"   name="cuenta" max="999999999">
        </div>
     
        <button type="submit" class="btn btn-warning btn-block w-5">Iniciar</button>
      </form>
    </div>
  </div>


</div>

  <div class='footer'> </div>

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

    .footer{
        width:100%;
        height:20vh;
        background-color:#91b400;
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
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
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