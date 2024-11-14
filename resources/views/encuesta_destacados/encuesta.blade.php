
@extends('layouts.app')

@section('content')


<div class="modal" id="myModal">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">AVISO DE PRIVACIDAD UNAM</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body text-justify">
El Programa de Vinculación con los Egresados de la Universidad Nacional Autónoma de México (UNAM), con domicilio en Zona Cultural de Ciudad Universitaria, Edificio D, planta baja, Alcaldía Coyoacán, C.P. 04510, en la Ciudad de México, es responsable del tratamiento de sus datos personales para el registro como egresado, difusión de información y generación de estadísticas para identificar, detectar e impulsar el desarrollo de oportunidades para los egresados de la UNAM.<br><br> No se realizarán transferencias de datos personales, salvo aquellas excepciones previstas por la Ley. Podrá ejercer sus derechos ARCO en  la Unidad de Transparencia de la UNAM, o a través de la Plataforma Nacional de Transparencia <br>(<a href='http://www.plataformadetransparencia.org.mx'>http://www.plataformadetransparencia.org.mx/</a>).<br><br>El aviso de privacidad integral se puede consultar en la sección Aviso de Privacidad de nuestro sitio web: <a href='http://www.pveaju.unam.mx/avisodeprivacidad'>http://www.pveaju.unam.mx/avisodeprivacidad</a>.
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
        </div>
        
      </div>
    </div>
  </div>
    <!--CABECERA/HEADER-->
    <div class="cabecera">
        <div class="logo">
        <a class=logoUNAM href="https://www.unam.mx/"> <img src="{{url('img/logos/logoUNAM-large-azul.png')}}"> </a>

            <a class=lovoPVE href="https://www.pveaju.unam.mx/"> <img src="{{url('img/logos/logoPVE-large.png')}}"> </a>
        </div>
        <div>
            <center>
                <b style='font-size:3.4vh'>ENCUESTA EGRESADOS DESTACADOS PVAJU UNAM</b>
            </center>
       
        </div>
        <div class="subtitulo2 ">
            <p>Secretaría General</p>
        </div>
    </div>

    <!--cpntenedpor de la encuesta-->
<div class="fondo_encuesta">
                <!-- lista de reactivos  -->
    <div class="blank_square" id="rlist">

                 <div class="texto-encuesta">
                 Estimad@ <b> @if($Egresado){{$Egresado->nombre}} {{$Egresado->paterno}}@endif </b>:
                 <hr>
                 <br>
                 En el marco del 40 aniversario del Programa de Vinculación con los Egresados, Queremos reconocer a <b>cuatro egresadas o egresados que han dejado una huella</b>, no solo en su profesión, sino también en nuestra sociedad, representando los valores de nuestra Universidad con su trabajo y compromiso.
                <br>
                Buscamos a aquellas personas que, en los ámbitos público, privado o social, <b>han hecho una diferencia</b>. Aquellas y aquellos egresados cuya labor ha fomentado y difundido los ideales universitarios <b>más allá de nuestras aulas</b> y ha contribuido al desarrollo de México y su sociedad. 
                <br>
                Te invitamos a ser parte de este reconocimiento, participando en la nominación de dos egresados universitarios (un hombre y una mujer en pos del eje rector de equidad de genero de la universidad) que consideres que cuentan con los méritos y logros que los hagan candidatos a este honor.
                <br>
                El Comité Organizador del PVEAJU seleccionará a cuatro egresados destacados y tu voz es clave para que esta celebración sea completa y amplia como nuestra Universidad. 

                 </div>
                 <div style="padding-right:10vh;padding-left:10vh;">
                <form action="{{ route('enc_destacados.save',$Egresado->id)}}" method="POST" enctype="multipart/form-data">
                   @csrf    
                   <h1 class="black_text" style="color:#002b7a; font-size:2.6vh">Quiero nominar a <b>LA EGRESADA:</b> </h1>
                   <div class="form-group">
                    <label for="exampleFormControlInput1">Nombre</label> <br>
                    @error('eg1')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input type="text" id="exampleFormControlInput1" style="border:3px solid #0f0f0f;font-size:2.8vh;width:70%" name='eg1' value="{{old('eg1')}}">

                 <h2 class="black_text" style='color:#002b7a; font-size:2.6vh'>Puesto que considero que su labor ha marcado una diferencia por los siguientes motivos:</h2>
             
                   <div class="form-group">
                   <label for="exampleFormControlInput1">Razones para la nominación</label> <br>
                   @error('reason1')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                   <textarea type="text" class="form-control" id="exampleFormControlInput1" style="border:3px solid #0f0f0f;font-size:2.1vh; width:70%" max='200' name='reason1' >{{old('reason1')}}</textarea>
                </div>
                <h1 class="black_text" style="color:#002b7a; font-size:2.6vh"> y al <b>EGRESADO:</b> </h1>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nombre</label> <br>
                    @error('eg2')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input type="text" id="exampleFormControlInput1" style="border:3px solid #0f0f0f;font-size:2.8vh;width:70%" name='eg2' value="{{old('eg2')}}">

                 <h2 class="black_text" style='color:#002b7a; font-size:2.6vh'>Puesto que considero que su labor ha marcado una diferencia por los siguientes motivos:</h2>
             
                   <div class="form-group">
                   <label for="exampleFormControlInput1">Razones para la nominación</label> <br>
                   @error('reason2')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror 
                   <textarea type="text" class="form-control" id="exampleFormControlInput1" style="border:3px solid #0f0f0f;font-size:2.1vh; width:70%" name='reason2' >{{old('reason2')}}</textarea>
                </div>
                <br>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Confirma tu numero de cuenta <p>*******{{substr($cuenta,-2)}}</p> para saber que eres tu </label>
                    @error('cuenta')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input type="text" class="form-control" name="cuenta" id="exampleFormControlInput1" value="{{old('cuenta')}}">
                </div>
               
        <br><br>
        <hr>
            <h1 class="black_text"> Confirma tus datos de contacto (Opcional)</h1>
          
            <div class="texto-encuesta">
            Para el programa de seguimiento de egresados es muy importante manenernos en comunicación con usted, por favor actualice sus datos de contacto, para que la universidad continue a la vanguardia de sus egresados, sus datos personales estan protegidos y puede consultar aquí el <a href="http://www.pveaju.unam.mx/avisodeprivacidad"><b>Aviso de Provacidad</b></a>
            </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nombre</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" @if($Egresado) value="{{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}" @endif disabled style="background-color:#868b94;">
                </div>
                
                <div class="form-group">
                    <label for="exampleFormControlInput1">Fecha de nacimiento</label>
                    <input type="date" class="form-control" id="exampleFormControlInput1" value="{{$Egresado->fec_nac}}" disabled style="background-color:#868b94">
                </div>
               
                <div class="form-group" >
                    <label for="exampleFormControlInput1">Correos</label>
                    @php   $count_correo=0; @endphp
                @if($Correos)
                    @foreach($Correos as $c)
                    
                            <input type="email" class="form-control"  value="{{$c->correo}}" name="correos[{{$count_correo}}]">
                              @php   $count_correo=$count_correo+1; @endphp
                          
                    @endforeach
                @endif    
                            <input type="email" class="form-control"   name="correos[{{$count_correo}}]" placeholder="Ingresa un correo actualizado">
                            
                            
                    <div id="correosDiv"></div>
                    <button style="background-color:#3fbd3c" type="button" onclick="add_correo()"><i class="fa fa-plus" aria-hidden="true"></i> Agregar otro</button>
                
                </div>
                <div class="form-group" >
                    <label for="exampleFormControlInput1">Números de Teléfono</label>
                    @php   $count_tel=0; @endphp
                @if($Telefonos)
                    @foreach($Telefonos as $t)
                    
                        <input type="text" class="form-control myinput"  value="{{$t->telefono}}" name="telefonos[{{$count_tel}}]" id="telefonos[{{$count_tel}}]", onkeyup="validate_phone({{$count_tel}})" placeholder="Ingresa un numero actualizado"> 
                        <p class="warning-label" id="warnlab[{{$count_tel}}]"> Ingresa al menos 10 dígitos </p>
                         @php   $count_tel=$count_tel+1; @endphp
                    @endforeach
                @endif
                    
                    <input type="text" class="form-control myinput"  value="" name="telefonos[{{$count_tel}}]" id="telefonos[{{$count_tel}}]", onkeyup="validate_phone({{$count_tel}})" placeholder="Ingresa un numero actualizado" > 
                    <p class="warning-label" id="warnlab[{{$count_tel}}]"> Ingresa almenos 10 digitos </p>

                  <div id="telefonosDiv">
                  </div>
                  <button style="background-color:#3fbd3c" type="button" onclick="add_tel()"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar otro </button>
                 
                    <!-- //pasando este loop agregar un telefono obligatorio y mover aqui el boton de mas -->
                </div>
               <input type="text" name='Eg_id' hidden value="{{$Egresado->id}}" >
                <center>
            <button id="final-button" class="btn blue_button" type="submit"> Guardar y enviar</button>

        </center>
        </div>
        </form>


            </div>
   
</div>
@endsection
@push('js')
@if ($errors->any())
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    Swal.fire({
        icon: "warning",
        title: "Hay algunos errores con el formulario",
        text: "Asegurate de haber ingresado todos los campos (nombres y razones de los nominados asi como tu numero de cuenta)     No es necesario, pero se les invita a actualizar sus datos de contacto para seguir comunicado con tu universidad.",
        imageUrl: "/img/logos/logoUNAM-large-azul.png",
        imageWidth: 150,
        imageHeight: 150,
        className: "red-bg",
        });
</script>
    @endif
<script>
    $(window).load(function(){
    $('#myModal').modal('show');
  })
</script>

 @endpush
 @include('encuesta2020.scripts.personal_data')

 @push('css')
 <style>
   .swal2-popup {
  font-size: 1.6rem !important;
  font-family: sans-serif;
}
 </style>

<style>
    .myinput{
     width:35%;
    }
</style>
@endpush