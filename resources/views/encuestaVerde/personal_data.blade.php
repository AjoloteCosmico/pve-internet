@extends('layouts.app')

@section('content')


    <!--CABECERA/HEADER-->
    <div class="cabecera">
        <div class="logo">
        <a class=logoUNAM href="https://www.unam.mx/"> <img src="{{url('img/logos/logoUNAM-large-azul.png')}}" style="width: 4.3vw !important; height:10vw !important" > </a>
       </div>
          <div class="subtitulo2">
       <p>Secretaría General</p>
        </div>
        <div class="logo">
            <a class=lovoPVE href="https://www.pveaju.unam.mx/"> <img src="{{url('img/logos/logoPVE-large.png')}}"> </a>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <a class=lovoPVE href="https://www.dgaco.unam.mx/"> <img src="{{url('img/logos/logo-dgaco.png')}}" style="width: 8vw !important; height:auto !important"> </a>
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
    <p class="blue_text"> {{$Carrera}}</p>
</div>

</div>

	<!--indicador lateral secciones-->
    <div class="blank_square sidebar">
          
                 </div>
                <!-- lista de reactivos  -->
                <div class="blank_square listaReactivos" id="rlist">
            @if($section=='personal_data')
                @include('encuesta2020.'.$section)
            @else
                @include('encuesta2020.reactivos')
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

<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script>
console.log('inicializar tippy');
  tippy('#cuadritonar81', {
    placement: 'top',
  });
</script>
 @endpush

 @push('css')
 <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/themes/light.css">

 <style>
   .swal2-popup {
  font-size: 1.6rem !important;
  font-family: sans-serif;
}
 </style>

 @endpush