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
El Programa de Vinculación con los Egresados y Académicos jubilados  de la Universidad Nacional Autónoma de México (UNAM), con domicilio en Zona Cultural de Ciudad Universitaria, Edificio D, planta baja, Alcaldía Coyoacán, C.P. 04510, en la Ciudad de México, es responsable del tratamiento de sus datos personales para el registro como egresado, difusión de información y generación de estadísticas para identificar, detectar e impulsar el desarrollo de oportunidades para los egresados de la UNAM.<br><br> No se realizarán transferencias de datos personales, salvo aquellas excepciones previstas por la Ley. Podrá ejercer sus derechos ARCO en  la Unidad de Transparencia de la UNAM, o a través de la Plataforma Nacional de Transparencia <br>(<a href='http://www.plataformadetransparencia.org.mx'>http://www.plataformadetransparencia.org.mx/</a>).<br><br>El aviso de privacidad integral se puede consultar en la sección Aviso de Privacidad de nuestro sitio web: <a href='https://www.pveaju.unam.mx/aviso-de-privacidad/'>https://www.pveaju.unam.mx/aviso-de-privacidad/</a>.
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
            <a class="logoUNAM" href="https://www.unam.mx/"> <img src="/img/logos/logoUNAM-large-azul.png"> </a>

            <a class="logoUNAM" href="https://www.unam.mx/"> <img src="/img/logos/nuestra_unam.png"> </a>
            PVEAJU UNAM
        </div>

        <div class="subtitulo2 "> Secretaría General
            <a class="lovoPVE" href="https://www.pveaju.unam.mx/"> <img src="/img/logos/logoPVE-large.png" style="width:9vh;"> </a>
            &nbsp;&nbsp;
            <a class="lovoPVE" href="https://www.pveaju.unam.mx/"> <img src="/img/logos/logo-cuadrado-SE-azul.png" style="width:7vh;"> </a>
        </div>
    </div>

    <!--INFORMACIÓN DE BIENVENIDA-->
<div class="main">
    
    <div class="izquierda">
        <div class="hero-continua">
            <img src="{{ asset('img/gráficos/ed_continua.jpg') }}" alt="Encuesta de Educación Continua UNAM">
            <div class="info" style="padding: 10px;">
        
        <br>
        <p class="texto2">
            Como parte de la campaña <span style="color: #e6af2b">reUNAMos Saberes</span> , invitamos a nuestras y nuestros egresados a participar 
            en esta encuesta que busca fortalecer el vínculo con la comunidad universitaria y enriquecer la oferta de educación continua cuyo propósito es conocer:

            <br><br>
            <ol>
                <li>
                    <span style="color: #e6af2b">Su opinión</span> 	 sobre los beneficios obtenidos con su formación profesional.
                </li>
                <li>
                     <span style="color: #e6af2b">Sus expectativas </span> al incorporarse al campo ocupacional de su profesión.
                </li>
                <li>
                    <span style="color: #e6af2b">Su grado de satisfacción </span>  con la preparación que recibió en la UNAM.
                </li>
            </ol>
            <br>
            Su participación es muy valiosa, ya que contribuirá a mejorar las oportunidades de
actualización y formación que ofrece nuestra Universidad.
        </p>
    </div>

        <!--CARDS PROPÓSITOS-->

    <div class="propositos">
        <!-- card 1 -->
             
        <div class="card-box">
            <p>
           Re<span class="amarillo">UNAM</span>os
            <span class="bigwhite"> Saberes</span> para
            <span class="bigwhite"> MANTENER VIVA</span> la
            <span class="amarillo"> CHISPA </span> del
            <span class="bigwhite">APRENDIZAJE</span> en nuestro dia a dia
        </div>
        <!-- card 2 -->
   
<div class="card-box">
            <p>
           La <span class="amarillo"> UNAM </span> 
            <span class="lilwhite"> genera conocimiento y </span>
            <span class="bigwhite"> EXPERIENCIAS </span> que mejoran y
            <span class="amarillo">TRANSFORMAN  </span>la vida del egresado
        </div>
        <!-- card 3 -->
  
<div class="card-box">
            <p>
            La <span class="amarillo">UNAM  </span> impulsa tu
            <span class="bigwhite">  CARRERA PROFESIONAL</span> con
            <span class="amarillo"> EDUCACIÓN CONTINUA</span> y
            <span class="bigwhite">APRENDIZAJE </span> profundo
        </div>




        
    </div>
        </div>
        
    </div>


<div class="derecha">

        <!--CUADRO DE INICIAR ENCUESTA-->
    <div class="iniciar">
        <p class="texto4">
            <b>DURACIÓN APROXIMADA: 7 MINUTOS</b>
        </p>
        <br>
        <p class="texto4">
            PARA GENERACIONES QUE INGRESARON ANTES DE 1999 SE ANTEPONE UN <b>"0"</b> EN EL NÚMERO DE CUENTA
        </p>
        <br>

        <form action="{{ route('enc_continua.verify')}}" method="POST" enctype="multipart/form-data">
        @csrf
        
            <ul>
                
            @if(session('externo') == 'si')
                <li>
                    <label>Número de Cuenta:  </label>
                    <input type="number" id="numeroCuenta"   name="cuenta" readonly value="{{session('cuenta')}}" style="background-color:#CCC"  />
                </li>
                <li>
                    <label>Apellido Paterno:</label>
                    <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" name="paterno" required />
                </li>
                <li>
                    <label>Apellido Materno:</label>
                    <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();"   name="materno" />
                </li>
                <li>
                    <label>Nombre(s):</label>
                    <input type="text" onkeyup="javascript:this.value=this.value.toUpperCase();" name="nombre" required />
                </li>
               <li>
                    <label>Plantel:</label> <br>
                     <select name="nbr3" id="nbr3" required style="font-size:14px">
                            <option value="" >Seleccione... </option> 

                            @foreach($Planteles as $option)
                            <option value="{{$option->clave_plantel}} " >{{$option->plantel}} </option> 

                            @endforeach
                            </select> 
                </li>
               <li>
                    <label>Carrera:</label> <br>
                   <select name="nbr2" id="nbr2" required style="font-size:14px">
                        <option value="" >Seleccione... </option> 
                        @foreach($Carreras as $option)
                        <option value="{{$option->clave}} " >{{$option->carrera}} </option> 
                        <br>
                        @endforeach
                    </select>
                </li>
               <li>
                    <label>Sexo:</label> <br>
                    <select name="sexo" id="" required style="font-size:14px">
                        <option value=""></option>
                        <option value="F">Femenino</option>
                        <option value="M">Masculino</option>
                    </select>
                </li>
                <li>
                    <label>Año de egreso:</label> <br>
                    <input type="number"  name="anio_egreso" min="1960" max="2027" required/>
                </li>
                <li>
                    <label>Su edad actual:</label> <br>
                    <input type="number"  name="edad" min="18" max="109" required/>
                </li>
                
            @else
                <li>
                    <label>Número de Cuenta:  </label>
                    <div class="field-glow">
                        <input type="number" id="numeroCuenta" name="cuenta" max="999999999" required class="cuenta-input" />
                    </div>
                </li>
            @endif
                <li>
                    <button type="submit">Iniciar encuesta</button>
                </li>
            </ul>
        </form>
    
        <br>
        <p class="texto8">
            <b>Preferentemente utilizar Google Chrome</b>
        </p>
    </div>

</div>
</div>
<!--AVISO DE PRIVACIDAD-->
<div class="aviso">
    <p class="texto4">
            LA INFORMACIÓN QUE PROPORCIONE SERÁ ESTRICTAMENTE CONFIDENCIAL Y SÓLO SE UTILIZARÁ CON FINES ESTADÍSTICOS.
    </p>

    <div class="botonAviso">
        <p class="texto7">IMPORTANTE</p>
        <a href="https://www.pveaju.unam.mx/aviso-de-privacidad">Aviso de Privacidad</a>
    </div>
</div>
@endsection

@push('css')
<style>
    .swal2-popup {
    font-size: 14px !important;
}

.swal2-styled {
    padding: 10px 32px 10px 32px !important;
    margin: 20px 10px 0px 10px !important;
    width: 170px;
    height: 45px;
}

.main {
    gap: 2.5rem;
}

.izquierda {
    width: 60%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-right: 2%;
}

.derecha {
    width: 40%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding-left: 2%;
}

.hero-continua {
    position: relative;
    width: 100%;
    max-width: 760px;
    border-radius: 26px;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.18);
    box-shadow: 0 18px 42px rgba(0, 0, 0, 0.28), 0 0 30px rgba(230, 175, 43, 0.12);
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.08), rgba(230, 175, 43, 0.08));
}

.hero-continua::before {
    content: "";
    position: absolute;
    inset: -16% -12%;
    background: radial-gradient(circle, rgba(230, 175, 43, 0.36), transparent 58%);
    filter: blur(28px);
    animation: pulseGlow 4.5s ease-in-out infinite;
}

.hero-continua img {
    position: relative;
    z-index: 1;
    display: block;
    width: 100%;
    height: auto;
    border-radius: 26px;
    object-fit: cover;
}

.iniciar {
    position: relative;
    width: 100%;
    max-width: 520px;
    background: rgba(255, 255, 255, 0.97);
    border: 1px solid rgba(0, 43, 122, 0.08);
    border-radius: 28px;
    padding: 2rem 1.7rem 1.25rem;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    font-size: smaller;
    box-shadow: 0 22px 45px rgba(5, 10, 48, 0.18), 0 8px 18px rgba(230, 175, 43, 0.15);
    transform: translateY(-4px);
    animation: floatPanel 4s ease-in-out infinite;
    overflow: hidden;
}

.iniciar::before {
    content: "";
    position: absolute;
    inset: 0;
    background: linear-gradient(120deg, transparent 0%, rgba(230, 175, 43, 0.15) 30%, rgba(0, 43, 122, 0.08) 50%, rgba(230, 175, 43, 0.15) 70%, transparent 100%);
    transform: translateX(-100%);
    animation: shimmer 4.5s ease-in-out infinite;
}

.iniciar > * {
    position: relative;
    z-index: 1;
}

form {
    width: 100%;
    margin: 10px auto 10px auto;
    color: black;
    font-weight: 600;
    font-size: small;
    border-radius: 18px;
}

form ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

form li {
    margin-bottom: 15px;
}

.field-glow {
    position: relative;
    display: inline-block;
    width: min(100%, 290px);
    margin: 0 auto 6px;
    padding: 2px;
    border-radius: 14px;
    background: linear-gradient(90deg, rgba(230, 175, 43, 0.15), rgba(0, 43, 122, 0.15), rgba(230, 175, 43, 0.7), rgba(0, 43, 122, 0.15), rgba(230, 175, 43, 0.15));
    background-size: 220% 100%;
    animation: scanGlow 3.8s linear infinite;
    box-shadow: 0 0 18px rgba(230, 175, 43, 0.24);
}

.field-glow input {
    position: relative;
    z-index: 1;
    width: 100%;
    margin: 0;
    border-radius: 12px;
    border: 1px solid #dfe4ef;
    background: linear-gradient(180deg, #fff 0%, #f7f8fb 100%);
    box-shadow: inset 0 2px 6px rgba(5, 10, 48, 0.08);
}

input {
    width: 80%;
    border: 1px solid gray;
    margin: 0 10px 20px 10px;
    border-radius: 5px;
    padding: 5px;
    box-shadow: inset gray 2px 2px 5px ;
}

button {
    background-color: #ba800d;
    color: white;
    padding: 10px 20px;
    border-radius: 12px;
    margin: 10px;
    text-decoration: none;
    border: 0;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    font-weight: 700;
    box-shadow: 0 12px 22px rgba(186, 128, 13, 0.28);
    font-size: small;
    transition: all 0.25s ease;
}

button:hover {
    background-color: #002b7a;
    transform: translateY(-3px);
    box-shadow: 0 16px 24px rgba(0, 43, 122, 0.22);
}

@keyframes floatPanel {
    0%, 100% { transform: translateY(-4px); }
    50% { transform: translateY(-10px); }
}

@keyframes shimmer {
    0% { transform: translateX(-120%); }
    40%, 100% { transform: translateX(120%); }
}

@keyframes pulseGlow {
    0%, 100% { opacity: 0.65; transform: scale(0.96); }
    50% { opacity: 1; transform: scale(1.04); }
}

@keyframes scanGlow {
    0% { background-position: 0% 50%; }
    100% { background-position: 200% 50%; }
}

@media (max-width: 980px) {
    .main {
        flex-direction: column;
        padding: 5% 6%;
    }

    .izquierda,
    .derecha {
        width: 100%;
        padding: 0;
    }

    .hero-continua {
        max-width: 100%;
    }
}
</style>
@endpush

@push('js')


@if (session('cuenta') == 'invalida')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
  icon: "warning",
  title: "Cuenta Invalida",
  text: "Parece que tu número de cuenta esta mal escrito, pues no corresponde a un formato valido para números de cuenta UNAM",
  footer: '<a href="#">Why do I have this issue?</a>'
});
</script>
@endif

@if (session('message') == 'realized')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
  icon: "success",
  title: "Encuesta realizada",
  text: "Parece que ya hemos capturado tus datos, gracias por participar en el estudio de seguimiento!",
  footer: '<a href="#">Why do I have this issue?</a>'
});
</script>
@endif

@if (session('externo') == 'si')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
  icon: "warning",
  title: "No tenemos tus datos en nuestros registros",
  html: "Por favor Ingresa a la encuesta llenando todos tus datos",
  
});
</script>
<script>
function removeOptions(selectElement) {
   var i, L = selectElement.options.length - 1;
   for(i = L; i >= 0; i--) {
      selectElement.remove(i);
   }
}

function set_carreras(seleccionado){
    console.log('entrando a la funcion');
        console.log(seleccionado)
removeOptions(document.getElementById('nbr2'));
var desc = document.getElementById("nbr2");
@foreach($Planteles as $p)
if(seleccionado=={{$p->clave_plantel}}){
    var example_array = {
        @foreach($Carreras as $carrera)
        @if($carrera->clave_plantel==$p->clave_plantel)
    {{$carrera->clave_carrera}} : '{{$carrera->carrera}}',
         @endif
    @endforeach
};
}
@endforeach
console.log(example_array);
for(index in example_array) {
    desc.options[desc.options.length] = new Option(example_array[index], index);
}
}

$(document).ready(function () {     
  $('#nbr3').change(function(){
        var seleccionado = $(this).val();
        set_carreras(seleccionado);
        
  });
  });
  var seleccionado = document.getElementById('nbr3').value;
  set_carreras(seleccionado);
  </script>
@endif
<script>
    $(window).load(function(){
    $('#myModal').modal('show');
  })
</script>
</script>

 @endpush