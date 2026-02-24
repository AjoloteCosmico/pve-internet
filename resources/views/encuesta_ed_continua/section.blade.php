@extends('layouts.app')

@section('content')


     <!--CABECERA/HEADER-->
    <div class="cabecera">
        <div class="logo">
            <a class="logoUNAM" href="https://www.unam.mx/"> <img src="/img/logos/logoUNAM-large-azul.png"> </a>
            <a class="logoUNAM" href="https://www.unam.mx/"> <img src="/img/logos/nuestra_unam.png"> </a>
            <a class="logoUNAM" href="https://www.unam.mx/"> <img src="/img/logos/Logo UNAM 475.jpg"> </a>
        </div>

        <div class="subtitulo2 ">
            <a class="lovoPVE" href="https://www.pveaju.unam.mx/"> <img src="/img/logos/logoPVE-large.png" style="width:9vh;"> </a> &nbsp;&nbsp;
            <a class="lovoPVE" href="https://www.pveaju.unam.mx/"> <img src="/img/logos/logo-cuadrado-SE-azul.png" style="width:7vh;"> </a>
        </div>
    </div>

    <!--cpntenedpor de la encuesta-->
<div class="fondo_encuesta">

<!--datos del egresado-->
<div class="blank_square horizontal">

<div class="datos">
    <p class="black_text"> Nombre:</p>
    <p class="blue_text"> {{$Encuesta->nombre}}  {{$Encuesta->paterno}}  {{$Encuesta->materno}}</p>
</div>

<div class="datos">
    <p class="black_text"> Número de Cuenta:</p>
    <p class="blue_text"> {{$Encuesta->cuenta}}</p>
</div>

<div class="datos">
    <p class="black_text"> Carrera:</p>
    <p class="blue_text"> {{$Encuesta->carrera}}</p>
</div>

<div class="datos">
    <p class="black_text"> Generación:</p>
    <p class="blue_text"> {{$Encuesta->anio_egreso}}</p>
</div>

</div>
	<!--indicador lateral secciones-->
    <div class="blank_square sidebar " style="width: 14vw;">
          <img class="card"  src="{{ asset('img/gráficos/lateral.png') }}" style="height: 80vh; width: 13.5vw; border-radius: 3%;" >
    </div>
                <!-- lista de reactivos  -->
                <div class="blank_square listaReactivos" id="rlist">
            @if($section=='personal_data')
                @include('encuesta_ed_continua.'.$section)
            @else
                @include('encuesta_ed_continua.reactivos')
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
@media (max-width: 991px) {
      .sidebar{
        display: none;
      }

      .header_logos{
        width:90% !important;
      }
    }
 </style>

 
 @endpush