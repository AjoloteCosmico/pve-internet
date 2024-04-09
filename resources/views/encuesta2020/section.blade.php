@extends('layouts.app')

@section('content')


    <!--CABECERA/HEADER-->
    <div class="cabecera">
        <div class="logo">
        <a class=logoUNAM href="https://www.unam.mx/"> <img src="{{url('img/logos/logoUNAM-large-azul.png')}}"> </a>

            <a class=lovoPVE href="https://www.pveu.unam.mx/"> <img src="{{url('img/logos/logoPVE-large.png')}}"> </a>
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
    <p class="black_text"> Carrera:</p>
    <p class="blue_text"> {{$Carrera}}</p>
</div>

</div>

	<!--indicador lateral secciones-->
    <div class="blank_square sidebar">
            <div class="row"><a class="btn section-btn @if($Encuesta->sec_a==1) completed @endif @if($section=='A') actual @endif"  > Sección 1: Sociodemográfico &nbsp; @if($Encuesta->sec_a==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif</a></div>
            <div class="row"><a class="btn section-btn @if($Encuesta->sec_e==1) completed @endif @if($section=='E') actual @endif"  > Sección 2: Actualización académica &nbsp; @if($Encuesta->sec_e==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif</a></div>
            <div class="row"><a class="btn section-btn @if($Encuesta->sec_f==1) completed @endif @if($section=='F') actual @endif"  > Sección 3: Satisfaccion con la institución &nbsp; @if($Encuesta->sec_f==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif</a></div>
            <div class="row"><a class="btn section-btn @if($Encuesta->sec_c==1) completed @endif @if($section=='C') actual @endif"  > Sección 4: Laboral&nbsp; @if($Encuesta->sec_c==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif </a></div>
            <div class="row"><a class="btn section-btn @if($Encuesta->sec_d==1) completed @endif @if($section=='D') actual @endif"  > Sección 5: Incorporación al mercado &nbsp; @if($Encuesta->sec_d==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif</a></div>
            <div class="row"><a class="btn section-btn @if($Encuesta->sec_g==1) completed @endif @if($section=='G') actual @endif"  > Sección 6: Habilidades&nbsp; @if($Encuesta->sec_g==1)<i class="fas fa-check-circle fa-xl" aria-hidden="true"></i> @endif </a></div>
            
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
                @include('encuesta2020.scripts.personal_data')
            @else
                @include('encuesta2020.scripts.section')
            @endif
 @endpush