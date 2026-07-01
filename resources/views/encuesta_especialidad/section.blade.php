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
                 &nbsp;&nbsp;
            <a class=lovoPVE href="https://posgrado.derecho.unam.mx/"> <img src="{{url('img/logos/escudo_derecho.png')}}" style="height: 6vh !important; width:auto !important"> </a>
      
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
    <p class="black_text"> Especialidad:</p>
    <p class="blue_text"> {{$Encuesta->especialidad}}</p>
</div>

<div class="datos">
    <p class="black_text"> Generación:</p>
    <p class="blue_text"> {{$Egresado->anio_egreso}}</p>
</div>

</div>
	<!--indicador lateral secciones-->
  <div class="blank_square sidebar">
    <div class="row"><a class="btn section-btn @if($Encuesta->sec_espa==1) completed @endif @if($section=='espA') actual @endif"  > Sección 1: Perfil del egresado &nbsp; @if($Encuesta->sec_espa==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif</a></div>
    <div class="row"><a class="btn section-btn @if($Encuesta->sec_espf==1) completed @endif @if($section=='espF') actual @endif"  > Sección 2: Datos académicos &nbsp; @if($Encuesta->sec_espf==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif</a></div>
    <div class="row"><a class="btn section-btn @if($Encuesta->sec_espe==1) completed @endif @if($section=='espE') actual @endif"  > Sección 3: Actualización académica &nbsp; @if($Encuesta->sec_espe==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif</a></div>
    <div class="row"><a class="btn section-btn @if($Encuesta->sec_espc==1) completed @endif @if($section=='espC') actual @endif"  > Sección 4: Satisfacción con la especialidad &nbsp; @if($Encuesta->sec_espc==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif </a></div>
    <div class="row"><a class="btn section-btn @if($Encuesta->sec_espg==1) completed @endif @if($section=='espG') actual @endif"  > Sección 4: Satisfacción con la especialidad &nbsp; @if($Encuesta->sec_espg==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif </a></div>
  </div>
                <!-- lista de reactivos  -->
                <div class="blank_square listaReactivos" id="rlist">
            @if($section=='personal_data')
                @include('encuesta_especialidad.'.$section)
            @else
                @include('encuesta_especialidad.reactivos')
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