@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div style="padding:30px;">
    <h1 class="text-white-50">Bienvenid@!!  {{Auth::user()->name }} {{Auth::user()->emojis }}</h1>
    <div>-----------------------------------------
        <br><br><br> 
    <a href="{{ route('report','reporte_individual')}}"  > <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white;">
    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Reporte Individual 2019
    </button></a>
    
    <a href="{{ route('report','reporte_individual_act2014')}}"  > <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white;">
    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Reporte Individual 2014
    </button></a>
    
    <a href="{{ route('report','correos_inconclusas')}}"  > <button class="btn" style="background-color:{{Auth::user()->color}} ; color:white;">
    <i class="fas fa-file-excel"></i> &nbsp; &nbsp; Correos par encuestas inconclusas
    </button></a>
    </div>
<br><br><br>
</div>
        {!! $chart->container() !!}
        {!! $aplica_chart->container() !!}


<script src="{{ $chart->cdn() }}"></script>
{!! $chart->script() !!}


    <script src="{{ $aplica_chart->cdn() }}"></script>
   <div style='color: black'>
    {!! $aplica_chart->script() !!}
    </div>
    </div>
@endsection
 @section('js')
 <script>
    $(document).ready(function() {
$('#tabla').dataTable();
} );
 </script>
 @stop