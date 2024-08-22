<form action="{{ route('enc20.update_personal_data',$Encuesta->registro)}}" method="POST" enctype="multipart/form-data">
                   @csrf    
            <h1 class="black_text"> Confirme sus datos de contacto</h1>
              
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nombre</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="{{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}" disabled style="background-color:#868b94">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Sexo</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" @if($Egresado->sexo=="M") value="Masculino" @else value="Femenino" @endif disabled style="background-color:#868b94">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Fecha de nacimiento</label>
                    <input type="date" class="form-control" id="exampleFormControlInput1" value="{{$Egresado->fec_nac}}" disabled style="background-color:#868b94">
                </div>
                
                <div class="form-group" >
                    <label for="exampleFormControlInput1">Correos</label>
                    @php   $count_correo=0; @endphp
                    @foreach($Correos as $c)
                    
                            <input type="email" class="form-control"  value="{{$c->correo}}" name="correos[{{$count_correo}}]">
                              @php   $count_correo=$count_correo+1; @endphp
                          
                    @endforeach
                    
                            <input type="email" class="form-control"   name="correos[{{$count_correo}}]" placeholder="Ingresa un correo actualizado">
                            
                            
                                
                    <div id="correosDiv"></div>
                    <button style="background-color:#3fbd3c" type="button" onclick="add_correo()"><i class="fa fa-plus" aria-hidden="true"></i> Agregar otro</button>
                
                </div>
                <div class="form-group" >
                    <label for="exampleFormControlInput1">Números de Teléfono</label>
                    @php   $count_tel=0; @endphp
                    @foreach($Telefonos as $t)
                    
                        <input type="text" class="form-control myinput"  value="{{$t->telefono}}" name="telefonos[{{$count_tel}}]" id="telefonos[{{$count_tel}}]", onkeyup="validate_phone({{$count_tel}})" placeholder="Ingresa un numero actualizado"> 
                        <p class="warning-label" id="warnlab[{{$count_tel}}]"> Ingresa al menos 10 dígitos </p>
                         @php   $count_tel=$count_tel+1; @endphp
                    @endforeach

                    
                    <input type="text" class="form-control myinput"  value="" name="telefonos[{{$count_tel}}]" id="telefonos[{{$count_tel}}]", onkeyup="validate_phone({{$count_tel}})" placeholder="Ingresa un numero actualizado" > 
                    <p class="warning-label" id="warnlab[{{$count_tel}}]"> Ingresa almenos 10 digitos </p>
                          
                            
                   
                  <div id="telefonosDiv">

                  </div>
                  <button style="background-color:#3fbd3c" type="button" onclick="add_tel()"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar otro </button>
                 
                    <!-- //pasando este loop agregar un telefono obligatorio y mover aqui el boton de mas -->
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Número de Cuenta</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1"  value="{{$Egresado->cuenta}}"  disabled style="background-color:#868b94">
                </div>
                @if($Encuesta->aplica2!=1)
                <div class="form-group">
                    <label for="exampleFormControlInput1">Carrera</label>
                  
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="{{$Carrera}}" disabled style="background-color:#868b94">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Plantel</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1"  value="{{$Plantel}}"  disabled style="background-color:#868b94">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Promedio</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="{{$Egresado->promedio}}" disabled style="background-color:#868b94">
                </div>
                @else
                @include('encuesta2020.general_reactives')
                @endif
                <center>
            <button id="final-button" class="btn blue_button" type="submit"> Guardar y enviar</button>
        </center>
        </form>


@push('css')
<style>
    .myinput{
     width:35%;
    }
</style>
@endpush