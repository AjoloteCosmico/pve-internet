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
                
                <div class="form-group" id="correosDiv">
                    <label for="exampleFormControlInput1">Correos</label>
                    @php   $count_correo=0; @endphp
                    @foreach($Correos as $c)
                    <table>
                        <tr>
                            <td>
                            <input type="text" class="form-control"  value="{{$c->correo}}" name="correos[{{$count_correo}}]">
                              @php   $count_correo=$count_correo+1; @endphp
                            </td>
                            <td>
                                
                    @if($count_correo==$Correos->count())
                    <button style="background-color:#3fbd3c" type="button" onclick="add_correo()"><i class="fa fa-plus" aria-hidden="true"></i> </button>
                    @endif
                            </td>
                        </tr>
                    </table>
                  
                    @endforeach
                </div>
                <div class="form-group" id="telefonosDiv">
                    <label for="exampleFormControlInput1">Numeros de Telefono</label>
                    @php   $count_tel=0; @endphp
                    @foreach($Telefonos as $t)
                    <table>
                        <tr>
                            <td>
                            <input type="text" class="form-control"  value="{{$t->telefono}}" name="telefonos[{{$count_tel}}]">
                              @php   $count_tel=$count_tel+1; @endphp
                            </td>
                            <td>
                                
                    @if($count_tel==$Telefonos->count())
                    <button style="background-color:#3fbd3c" type="button" onclick="add_tel()"><i class="fa fa-plus" aria-hidden="true"></i> </button>
                    @endif
                            </td>
                        </tr>
                    </table>
                  
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Numero de Cuenta</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1"  value="{{$Egresado->cuenta}}"  disabled style="background-color:#868b94">
                </div>
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
                <center>
            <button class="btn blue_button" type="submit"> Guardar y enviar</button>
        </center>
        </form>