<form action="{{ route('enc_posgrado.update_personal_data',$Encuesta->registro)}}" method="POST" enctype="multipart/form-data">
                   @csrf    
            <h1 class="black_text"> Confirme sus datos de contacto</h1>
              
                <div class="form-group">
                    <label for="exampleFormControlInput1">Nombre</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="{{$Egresado->nombre}} {{$Egresado->paterno}} {{$Egresado->materno}}" disabled style="background-color:#868b94">
                </div>
               
                <div class="form-group">
                    <label for="exampleFormControlInput1">Número de Cuenta</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1"  value="{{$Egresado->cuenta}}"  disabled style="background-color:#868b94">
                </div>
                @php
                      
                        use App\Models\EgresadoPos;
                    @endphp
                @if($Egresado->fuente=='internet')

                    @php
                    $Programas=EgresadoPos::select('programa')->whereNotNull('programa')->distinct()->get();
                    
                    $Planes=EgresadoPos::select('plan')->whereNotNull('plan')->distinct()->get();
                    @endphp
                <div class="form-group">
                    <label for="exampleFormControlInput1" >* Programa de posgrado</label>
                    <select name="programa" class="form-control" id="select_programa" onchange="checkNotNa(this)">
                        <option value="">Seleccione </option>
                        @foreach($Programas->sortBy('programa') as $p)
                            <option value="{{$p->programa}}" @if($Egresado->programa==$p->programa) selected @endif>{{$p->programa}}</option>
                        @endforeach
                  </select>
                </div>
                
                <div class="form-group">
                    <label for="exampleFormControlInput1">* Plan de Estudios</label>
                  
                    <select name="plan" class="form-control" id="select_plan" onchange="checkNotNa(this)">
                    <option value="">Seleccione </option>
                    @foreach($Planes->sortBy('plan') as $p)
                        <option value="{{$p->plan}}" @if($Egresado->plan==$p->plan) selected @endif>{{$p->plan}}</option>
                    @endforeach
                  </select>
                </div>
                
                 <div class="form-group">
                    <label for="exampleFormControlInput1">* ¿Ya cuenta con grado?</label>
                     <select class="form-control" name="grado" id="select_grado" onchange="checkNotNa(this)">
                        <option value="">Seleccione</option>
                        <option value="SI" @if($Egresado->grado=="SI") selected @endif>SI</option>
                        <option value="NO" @if($Egresado->grado=="NO") selected @endif >NO</option>
                     </select>   
                </div>
                 <div class="form-group">
                    <label for="exampleFormControlInput1">* Año en que obtuvo el grado</label>
                    <input type="number" step="1" class="form-control" @if($Egresado->anio_egreso) value="{{$Egresado->anio_egreso}}" @else value="" @endif onchange="checkNotNa(this)" id="anio" name="anio" placeholder="Año en que obtuvo u obtendrá el grado" min="1970" max="2027" >
                </div>
                @else
                 <div class="form-group">
                    <label for="exampleFormControlInput1">Sexo</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" @if($Egresado->sexo=="M") value="Masculino" @else value="Femenino" @endif disabled style="background-color:#868b94">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1">Plan de Estudios</label>
                  
                    <input type="text" class="form-control" id="exampleFormControlInput1" value="{{$Egresado->plan}}" disabled style="background-color:#868b94">
                </div>
                @endif
                <p>* campos obligatorios</p>
               
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
                    
                        <input type="text" class="form-control myinput"  value="{{$t->telefono}}" name="telefonos[{{$count_tel}}]" id="telefonos[{{$count_tel}}]", onkeyup="validate_phone({{$count_tel}})" placeholder="Ingresa un número actualizado"> 
                        <p class="warning-label" id="warnlab[{{$count_tel}}]"> Ingresa al menos 10 dígitos </p>
                         @php   $count_tel=$count_tel+1; @endphp
                    @endforeach

                    <input type="text" class="form-control myinput"  value="" name="telefonos[{{$count_tel}}]" id="telefonos[{{$count_tel}}]", onkeyup="validate_phone({{$count_tel}})" placeholder="Ingresa un número actualizado" > 
                    <p class="warning-label" id="warnlab[{{$count_tel}}]"> Ingresa almenos 10 digitos </p>
                                             
                  <div id="telefonosDiv">

                  </div>
                  <button style="background-color:#3fbd3c" type="button" onclick="add_tel()"> <i class="fa fa-plus" aria-hidden="true"></i> Agregar otro </button>
                 
                    <!-- //pasando este loop agregar un telefono obligatorio y mover aqui el boton de mas -->
                </div>
                
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