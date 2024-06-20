@extends('layouts.app')

@section('content')
    <!--CABECERA/HEADER-->
    <div class="cabecera">
        <div class="logo">
            <a class=logoUNAM href="https://www.unam.mx/"> <img src="img/logos/logoUNAM-large-azul.png"> </a>

            <a class=lovoPVE href="https://www.pveu.unam.mx/"> <img src="img/logos/logoPVE-large.png"> </a>
        </div>

        <div class="subtitulo2 ">
            <p>Secretaría General</p>
        </div>
    </div>

    <!--MENSAJE-->
<div class="mainFinal">
<div class="izquierda">
<div class="info">
    <p class="subtitulo3 principal">
        ENCUESTA FINALIZADA
    </p>
    <br>
    <p class="subtitulo">
        <span style="color: #e6af2b"><b>¡AGRADECEMOS SU PARTICIPACIÓN!</b></span>
    </p>
    <br><br>
    <p class="texto2">
        Los resultados obtenidos servirán para contribuir al mejoramiento de esta Máxima Casa de Estudios
    </p>
    <br><br>
    <p class="texto2">
        <a href="index.html#creditos"><span style= "font-size:min(1.9vh);text-decoration:underline;">CRÉDITOS</span></a>
    </p>
</div>

<div class="finalBtn">
    <div class="boton1">
        <a href="index.html#resultadosCarrera">FINALIZAR Y SALIR</a>
    </div>
</div>

</div>

<div class="derecha">

    <!--CARDS PROPÓSITOS-->

    <div class="propositosFinal">
        <img class="card" src="img/gráficos/pag-encuesta-1.png">

        <img class="card" src="img/gráficos/pag-encuesta-2.png">

        <img class="card" src="img/gráficos/pag-encuesta-3.png">
    </div>

</div>
</div>

@endsection