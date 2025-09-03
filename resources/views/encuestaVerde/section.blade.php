@extends('layouts.app')

@section('content')

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
<div>
     <img src="{{ asset('img/verde/header.png') }}" class="header_logos" style="width:20vw;" alt="Header" >
</div>

</div>

	<!--indicador lateral secciones-->
    <div class="blank_square sidebar " style="width: 20vw; padding:.3 vw !important">
          <img class="card"  src="{{ asset('img/verde/hoja_delgado.png') }}" >
    </div>
      
            <!-- lista de reactivos  -->
                <div class="blank_square listaReactivos" id="rlist">
            @if($section=='personal_data')
                @include('encuestaVerde.'.$section)
            @else
                @include('encuestaVerde.reactivos')
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
    .verde{
        background-color: #152824  !important;
        /* #29524a */
    }
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
 </style>

 @endpush