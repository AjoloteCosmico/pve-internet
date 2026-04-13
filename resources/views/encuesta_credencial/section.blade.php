@extends('layouts.app')

@section('content')


     <!--CABECERA/HEADER-->
    <div class="cabecera">
        <div class="logo">
            <a class="logoUNAM" href="https://www.unam.mx/"> <img src="/img/logos/logoUNAM-large-azul.png"> </a>

            <a class="logoUNAM" href="https://www.unam.mx/"> <img src="/img/logos/nuestra_unam.png"> </a>
        </div>

        <div class="subtitulo2 ">
            <a class="lovoPVE" href="https://www.pveaju.unam.mx/"> <img src="/img/logos/logoPVE-large.png" style="width:9vh;"> </a>
                 &nbsp;&nbsp;&nbsp;&nbsp;
            <a class=lovoPVE href="https://www.posgrado.unam.mx/"> <img src="{{url('img/logos/logo-cuadrado-SE-azul.png')}}" style="width: 5vh !important; height:auto !important"> </a>
       
        </div>
    </div>

<!--cpntenedpor de la encuesta-->
<div class="fondo_encuesta">
<!--datos del egresado-->
<div class="blank_square horizontal">

<div class="datos">
    <p class="black_text"> Nombre:</p>
    <p class="blue_text"> EGRESADO DE PRUEBA</p>
</div>

<div class="datos">
    <p class="black_text"> Número de Cuenta:</p>
    <p class="blue_text">00000000 </p>
</div>

<div class="datos">
    <p class="black_text"> Carrera:</p>
    <p class="blue_text"> Arquitectura </p>
</div>

<div class="datos">
    <p class="black_text"> Generación:</p>
    <p class="blue_text"> 2025</p>
</div>

</div>
	<!--indicador lateral secciones-->
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