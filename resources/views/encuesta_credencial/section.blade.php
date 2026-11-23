@extends('layouts.app')

@section('content')

     <!--CABECERA/HEADER-->
    <div class="cabecera">
        <div class="logo">
            <a class="logoUNAM" href="https://www.unam.mx/"> <img src="/img/logos/logoUNAM-large-azul.png"> </a>
            <a class="logoUNAM" href="https://www.unam.mx/"> <img src="/img/logos/nuestra_unam.png"> </a>
        </div>

        <div class="subtitulo2 "> Secretaría General
            &nbsp;&nbsp;
            <a class="lovoPVE" href="https://www.pveaju.unam.mx/"> <img src="https://www.pveaju.unam.mx/wp-content/uploads/2025/03/logo-pveaju-color-12.png" style="width:9vh;"> </a>
            &nbsp;&nbsp;
            <a class="lovoPVE" href="https://www.pveaju.unam.mx/encuesta/01/seguimiento_egresados_UNAM/"> <img src="/img/logos/logo-SE-azul.png" style="width:9vh;"> </a>
        </div>
    </div>


<!--contenedor de la encuesta-->
<div class="fondo_encuesta">
<!--datos del egresado-->
<div class="blank_square horizontal">

<div class="datos">
    <p class="black_text"> Nombre:</p>
    <p class="blue_text"> {{$Encuesta->nombre . ' ' . $Encuesta->paterno }}</p>
</div>

<div class="datos">
    <p class="black_text"> Número de Cuenta:</p>
    <p class="blue_text">{{$Encuesta->cuenta}} </p>
</div>

<div class="datos">
    <p class="black_text"> Carrera:</p>
    <p class="blue_text"> {{$Encuesta->carrera}} </p>
</div>

</div>
    <!--indicador lateral secciones-->
     <div class="blank_square sidebar">
         <img class="card" src="{{ asset('img/gráficos/side-cred.jpg') }}" alt="Credencial Mockup">
     </div>
         
     <!-- lista de reactivos  -->
     <div class="blank_square listaReactivos" id="rlist">
         @if($section=='personal_data')
             @include('encuesta_credencial.'.$section)
         @else
             @include('encuesta_credencial.reactivos')
         @endif
     </div>
   
</div>
@endsection

@push('js')
@if($section=='personal_data')
    @include('scripts.personal_data')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    Swal.fire({
        icon: "info",
        title: "¡Mantente conectado a tu Universidad!",
        text: "Por favor ingresa al menos un teléfono y un correo que utilices regularmente",
        imageUrl: "/img/logos/logoUNAM-large-azul.png",
        imageWidth: 150,
        imageHeight: 150,
        className: "red-bg",
    });
    </script>
@else
    @include('scripts.section')
@endif
@endpush

@push('css')
<style>
   .swal2-popup {
     font-size: 1.6rem !important;
     font-family: sans-serif;
   }

   /* Contenedor lateral con ancho fijo basado en la imagen */
   .sidebar {
       width: 250px !important; /* Puedes ajustar este valor exacto al ancho real de tu imagen */
       height: 80vh;
       display: flex;
       flex-direction: column;
       padding: 0;
       overflow: hidden;
   }

   /* La imagen se ajusta por completo al recuadro blanco */
   .sidebar .card {
       width: 100% !important;
       height: 100% !important;
       object-fit: cover; /* Evita que la imagen se deforme cubriendo todo el espacio */
       border-radius: 3%;
   }

   @media (max-width: 991px) {
      .header_logos {
        width: 90% !important;
      }
   }
</style>
@endpush