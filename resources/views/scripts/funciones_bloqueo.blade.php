<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
// TODO:
//     1: deshabilitar todos los reactivos salvo el primero
//             -como saber cual es el primero :O
//     2: al contestar, habilitar sig, scroll
var reactivos=[@foreach($Reactivos as $r) @if($r->type!='label') '{{$r->clave}}', @endif @endforeach];
//reactivos que no se contestan
//se ira llenando dependiendo de las respuestas que bloqueen otros reactivos
var no_se_contestan=[];
//reactivos que permaneces bloqueados para evitar que se cconteste en desorden
var aun_no=reactivos.shift();
var  checked_boxes=[];
var all_bloqueos=[
    @foreach($Bloqueos as $b)
    {
        "clave_reactivo": "{{$b->clave_reactivo}}",
         "valor":{{$b->valor}},
         "prueba_p": {{$b->valor}},
         "bloqueado":"{{$b->bloqueado}}"
    },
    
    @endforeach
]
// console.log(filteredArray);
console.log(reactivos);

function showlabel(id){
    console.log('showing.label')
 var element = document.getElementById(id);
  element.classList.toggle("active");
// Swal.fire({
//   title: "CPresiona enter cuando termines",
//   showClass: {
//     popup: `
//       animate__animated
//       animate__fadeInUp
//       animate__faster
//     `
//   },
//   hideClass: {
//     popup: `
//       animate__animated
//       animate__fadeOutDown
//       animate__faster
//     `
//   }});
   }


function dishable_reactive(react_name){
    console.log('deshabilitar '+react_name);
    $("#"+react_name).children().prop('disabled', true);
    $("#"+react_name).css("background-color","#e6e6e6");
    $("#"+react_name).css("color","#a6a6a6");
    
    var cells = document.getElementsByClassName('op'+react_name); 
    for (var i = 0; i < cells.length; i++) { 
        cells[i].disabled = true;
    }

    var cells = document.getElementsByClassName(react_name+'opcion'); 
    for (var i = 0; i < cells.length; i++) { 
        cells[i].disabled = true;
    }
}

function hable_reactive(react_name){
    console.log('habilitar '+react_name);
    $("#"+react_name).children().prop('disabled', false);
    $("#"+react_name).css("background-color","#ffffff");
    $("#"+react_name).css("color","#000000");
    
    var cells = document.getElementsByClassName('op'+react_name); 
    for (var i = 0; i < cells.length; i++) { 
        cells[i].disabled = false;
    }
    var cells = document.getElementsByClassName(react_name+'opcion'); 
    for (var i = 0; i < cells.length; i++) { 
        cells[i].disabled = false;
    }
}

function optionWasClicked(react_name,for_block,involucrados,option_key=0){
    if($("#"+react_name).children().prop('disabled')){
        return 0;
    }
    if(option_key!=0){
        document.getElementById(react_name+'op'+option_key).checked = true;
    }
    var els = document.getElementsByClassName("cuadrito-"+react_name);

    Array.prototype.forEach.call(els, function(el) {
        // Do stuff here
        el.style.backgroundColor = '#FFFFFF';
        el.style.color = '#000000';
    });
    console.log('cuadrito'+react_name+option_key);
    document.getElementById('cuadrito'+react_name+option_key).style.backgroundColor = '#002b7a';
    document.getElementById('cuadrito'+react_name+option_key).style.color = '#FFFFFF';
    console.log('involucrados',involucrados);
    last_index=reactivos.indexOf(react_name);
    last_index=last_index+1;
    reactivo_siguiente=reactivos[last_index];

    
    //si hay reactivos que deben bloquearse segun la opcion que se selecciono
    //entonces los agregamos a la lista de reactivos que no se contestan
    
        //primero hay que quuitar (si hay alguno), los reactivos que pudieron haber sido bloqueados con otra opacion
        //y ahora que se selleciona una opcion de nuevo no debe haber ninguno del reactivo en ceustion
    if(involucrados.length>0){
        for (var i = 0; i < involucrados.length; i++) {
            if(no_se_contestan.includes(involucrados[i])){
                 no_se_contestan.splice(no_se_contestan.indexOf(involucrados[i]),1);
                 hable_reactive(involucrados[i]);
               }
            }
            console.log('resetenadno lista de no contestar');
               console.log(involucrados);
               console.log(no_se_contestan);
        }
        //si es que hay algo que bloquear lo ahce
        console.log('agregando a no se contestan');
        console.log('por bloquear: ', for_block);
    if(for_block.length>0){
        for (var i = 0; i < for_block.length; i++) {
            
            no_se_contestan.push(for_block[i]);
            console.log(no_se_contestan);
        console.log(no_se_contestan.includes(String(reactivo_siguiente)));
        console.log('deshabilitando '+for_block[i])
        dishable_reactive(for_block[i]);
            }
        
       
        
        }

    //verificar que el sig reactivo no este en la lista
    console.log('el reactivo sig, por ahora, es '+reactivo_siguiente);
    console.log(for_block);
    console.log(for_block.length);
    console.log('start while')
    while((no_se_contestan.includes(reactivo_siguiente)) &&( last_index<reactivos.length)) {
        
        last_index=last_index+1;
        console.log(last_index);
        dishable_reactive(reactivo_siguiente);
        reactivo_siguiente=reactivos[last_index];
        console.log('el reactivo sig, por ahora, es '+reactivo_siguiente);
}

console.log('nreactivos',reactivos.length);
console.log('reactivo siguiente',reactivo_siguiente);
if(last_index>=reactivos.length){
    $("#final-button").removeAttr("disabled");
    var element = document.getElementById('final-button');
    }else{
    hable_reactive(reactivo_siguiente);
    var element = document.getElementById(reactivo_siguiente+'-redact');
}
    var ventana = document.getElementById('rlist');
    var elementPosition = element.getBoundingClientRect().top;
    console.log(elementPosition+' POSICIONADO');
    console.log(element);  
    ventana.scrollTop= ventana.scrollTop+elementPosition-50-ventana.getBoundingClientRect().top;
    document.getElementById('monitor_reactivos_cerrrados').innerHTML=no_se_contestan;
}

function optionWasSelected(react_name,involucrados){

    var val=document.getElementById('select-'+react_name).value;
    
    for_block = all_bloqueos.filter(item => item.valor == val);
    console.log('selected: ',val,for_block);
    last_index=reactivos.indexOf(react_name);
    last_index=last_index+1;
    reactivo_siguiente=reactivos[last_index];
    if(involucrados.length>0){
        for (var i = 0; i < involucrados.length; i++) {
            if(no_se_contestan.includes(involucrados[i])){
                 no_se_contestan.splice(no_se_contestan.indexOf(involucrados[i]),1);
                 hable_reactive(involucrados[i]);
               }
            }
            console.log('resetenadno lista de no contestar');
               console.log(involucrados);
               console.log(no_se_contestan);
        }

        console.log('agregando a no se contestan');
        console.log('por bloquear: ', for_block);
    if(for_block.length>0){
        for (var i = 0; i < for_block.length; i++){
            no_se_contestan.push(for_block[i].bloqueado);
            console.log(no_se_contestan);
        console.log(no_se_contestan.includes(String(reactivo_siguiente)));
        console.log('deshabilitando '+for_block[i].bloqueado)
        dishable_reactive(for_block[i].bloqueado);
            }
        }

    console.log(for_block);
    console.log(for_block.length);
    console.log('start while')
    while((no_se_contestan.includes(reactivo_siguiente)) &&( last_index<reactivos.length)) {
        
        last_index=last_index+1;
        console.log(last_index);
        dishable_reactive(reactivo_siguiente);
        reactivo_siguiente=reactivos[last_index];
        console.log('el reactivo sig, por ahora, es '+reactivo_siguiente);
    }

console.log('nreactivos',reactivos.length);
console.log('reactivo siguiente',reactivo_siguiente);
if(last_index>=reactivos.length){
    $("#final-button").removeAttr("disabled");
    var element = document.getElementById('final-button');
    }else{
    hable_reactive(reactivo_siguiente);
    var element = document.getElementById(reactivo_siguiente+'-redact');
}
    var ventana = document.getElementById('rlist');
    var elementPosition = element.getBoundingClientRect().top;
    console.log(elementPosition+' POSICIONADO');
    console.log(element);  
    ventana.scrollTop= ventana.scrollTop+elementPosition-50-ventana.getBoundingClientRect().top;
    document.getElementById('monitor_reactivos_cerrrados').innerHTML=no_se_contestan;
}

function MultipleOptionWasClicked(react_name){
    last_index=reactivos.indexOf(react_name);
    last_index=last_index+1;
    reactivo_siguiente=reactivos[last_index];


    //verificar que el sig reactivo no este en la lista
    console.log('el reactivo sig, por ahora, es '+reactivo_siguiente);
    console.log(for_block);
    console.log(for_block.length); 
    console.log('start while')
    while((no_se_contestan.includes(reactivo_siguiente)) &&( last_index<reactivos.length)) {
        
        last_index=last_index+1;
        console.log(last_index);
        dishable_reactive(reactivo_siguiente);
        reactivo_siguiente=reactivos[last_index];
        console.log('el reactivo sig, por ahora, es '+reactivo_siguiente);
    
}

console.log('nreactivos',reactivos.length);
console.log('reactivo siguiente',reactivo_siguiente);
if(last_index>=reactivos.length){
    $("#final-button").removeAttr("disabled");
    }else{
    hable_reactive(reactivo_siguiente);
    }
}

function unblockNext(react_name){
    var element = document.getElementById(react_name+'label');
     element.classList.toggle("active");
    last_index=reactivos.indexOf(react_name);
    reactivo_siguiente=reactivos[last_index+1];
    //verificar que el sig reactivo no este en la lista
    while(no_se_contestan.includes(reactivo_siguiente)) {
        last_index=last_index+1;
        dishable_reactive(reactivo_siguiente);
        reactivo_siguiente=reactivos[last_index+1];
        console.log('el reactivo sig, por ahora, es '+reactivo_siguiente);}

    if(last_index+1>=reactivos.length){
        $("#final-button").removeAttr("disabled");
        var element = document.getElementById('final-button');
        console.log('es el boton');
    }else{
        console.log('toca: '+reactivo_siguiente);
        console.log('el indice es '+last_index);
        console.log(reactivos)
        hable_reactive(reactivo_siguiente);
        var element = document.getElementById(reactivo_siguiente+'-redact');
}
    var ventana = document.getElementById('rlist');
    var elementPosition = element.getBoundingClientRect().top;
    
    ventana.scrollTop= ventana.scrollTop+elementPosition-50-ventana.getBoundingClientRect().top;
    console.log(elementPosition+' POSICIONADO');
    console.log(element);
}

function optionChecked(react_name,op,bloqueados){

    var element = document.getElementById(react_name+'label');
    var opciones=document.getElementsByClassName(react_name+'opcion');
    almenos_una_opcion=0;
    console.log(opciones);
    for(i=0;i<opciones.length;i++){
        console.log(opciones[i].checked);
        if(opciones[i].checked){

            almenos_una_opcion=1;
        }
    }
    
    if(almenos_una_opcion){
        if( !element.classList.contains('active')){
            element.classList.toggle("active");
        }
    }else{
        if( element.classList.contains('active')){
            element.classList.toggle("active");
        }
    }
    if(bloqueados.length>0){
        if(document.getElementById(react_name+'op'+String(op)).checked){
            
            for (var j = 0; j < bloqueados.length; j++) {
                no_se_contestan.push(bloqueados[j]);
                dishable_reactive(bloqueados[j]);
            }
            
            }else{
                
                for (var j = 0; j < bloqueados.length; j++) {
                hable_reactive(bloqueados[j]);
                if(no_se_contestan.includes(bloqueados[j])){
                 no_se_contestan.splice(no_se_contestan.indexOf(bloqueados[j]),1);
                 
                  }
                }
                
            
            }     
    }
}

function siguiente(react_name){
    last_index=reactivos.indexOf(react_name);
    last_index=last_index+1;
    reactivo_siguiente=reactivos[last_index]; 
    while((no_se_contestan.includes(reactivo_siguiente)) &&( last_index<reactivos.length)) {   
        last_index=last_index+1;
        console.log(last_index);
        dishable_reactive(reactivo_siguiente);
        reactivo_siguiente=reactivos[last_index];
        console.log('el reactivo sig, por ahora, es '+reactivo_siguiente);
}

console.log('nreactivos',reactivos.length);
console.log('reactivo siguiente',reactivo_siguiente);
if(last_index+1>=reactivos.length){
    $("#final-button").removeAttr("disabled");
    var element = document.getElementById('final-button');
    }else{
    hable_reactive(reactivo_siguiente);
    var element = document.getElementById(reactivo_siguiente+'-redact');
}
    var ventana = document.getElementById('rlist');
    var elementPosition = element.getBoundingClientRect().top;
    console.log(elementPosition+' POSICIONADO');
    console.log(element);  
    ventana.scrollTop= ventana.scrollTop+elementPosition-50-ventana.getBoundingClientRect().top;
}

function submitForm(){
    

    for (var i = 0; i < no_se_contestan.length; i++) {
        console.log('cambiando valores',no_se_contestan[i]);
        document.getElementsByName(no_se_contestan[i])[0].value="0";
        }
    $("#main_form").submit();
}

for (var i = 1; i < reactivos.length; i++) { dishable_reactive(reactivos[i]);}

</script>
