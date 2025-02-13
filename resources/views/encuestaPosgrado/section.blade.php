@extends('layouts.app')

@section('content')


    <!--CABECERA/HEADER-->
    <div class="cabecera">
        <div class="logo">
        <a class=logoUNAM href="https://www.unam.mx/"> <img src="{{url('img/logos/logoUNAM-large-azul.png')}}"> </a>

            <a class=lovoPVE href="https://www.pveaju.unam.mx/"> <img src="{{url('img/logos/logoPVE-large.png')}}"> </a>
        </div>

        <div class="subtitulo2 ">
            <p>Secretaría General</p>
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
    <p class="black_text"> Numero de cuenta:</p>
    <p class="blue_text"> {{$Encuesta->cuenta}}</p>
</div>

<div class="datos">
    <p class="black_text"> Plan de estudios:</p>
    <p class="blue_text"> {{$Egresado->plan}}</p>
</div>
<div class="datos">
    <p class="black_text"> Graduado:</p>
    <p class="blue_text"> {{$Egresado->grado}}</p>
</div>

</div>
	<!--indicador lateral secciones-->
    <div class="blank_square sidebar">
            <div class="row"><a class="btn section-btn @if($Encuesta->sec_pa==1) completed @endif @if($section=='pA') actual @endif"  > Sección 1: Datos Sociodemográficos &nbsp; @if($Encuesta->sec_pa==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif</a></div>
            <div class="row"><a class="btn section-btn @if($Encuesta->sec_pb==1) completed @endif @if($section=='pB') actual @endif"  > Sección 2: Obtención del Grado &nbsp; @if($Encuesta->sec_pb==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif</a></div>
            <div class="row"><a class="btn section-btn @if($Encuesta->sec_pc==1) completed @endif @if($section=='pC') actual @endif"  > Sección 3: Actualización Academica &nbsp; @if($Encuesta->sec_pc==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif</a></div>
            <div class="row"><a class="btn section-btn @if($Encuesta->sec_pd==1) completed @endif @if($section=='pD') actual @endif"  > Sección 4: Datos Laborales &nbsp; @if($Encuesta->sec_pd==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif </a></div>
            <div class="row"><a class="btn section-btn @if($Encuesta->sec_pe==1) completed @endif @if($section=='pE') actual @endif"  > Sección 5: Satisfacción con la institución &nbsp; @if($Encuesta->sec_pe==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif</a></div>
                 </div>
                <!-- lista de reactivos  -->
                <div class="blank_square listaReactivos" id="rlist">
            @if($section=='personal_data')
                @include('encuestaPosgrado.'.$section)
            @else
                @include('encuestaPosgrado.reactivos')
            @endif
            </div>
   
</div>
@endsection
@push('js')

@if($section=='personal_data')
                @include('encuestaPosgrado.scripts.personal_data')

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
                @include('encuestaPosgrado.scripts.section')
            @endif
 @endpush

 @push('css')
 <style>
   .swal2-popup {
  font-size: 1.6rem !important;
  font-family: sans-serif;
}
 </style>
 @endpush