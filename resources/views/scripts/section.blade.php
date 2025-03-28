<link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script type="text/javascript">

    console.log("Jalando");
   // TODO:
   //     1: deshabilitar todos los reactivos salvo el primero
   //             -como saber cual es el primero :O
   //     2: al contestar, habilitar sig, scroll
   var reactivos=[@foreach($Reactivos as $r) @if($r->type!='label') '{{$r->clave}}', @endif @endforeach];
   //reactivos que no se contestan
   //se ira llenando dependiendo de las respuestas que bloqueen otros reactivos
   var no_se_contestan=[];
   
   //reactivos que permaneces bloqueados para evitar que se cconteste en desorden
   var aun_no=reactivos.slice(1,reactivos.lenght);//inicia como la lista de reactivos sin el primer elemento
   var  checked_boxes=[];//cajas que han sido seleccionadas?
   // Vaciamos la query de bloqueos a un array de objetos js
   var all_bloqueos=[
       @foreach($Bloqueos as $b)
       {
           "clave_reactivo": "{{$b->clave_reactivo}}",
            "valor":{{$b->valor}},
            "prueba_p": {{$b->valor}},
            "bloqueado":"{{$b->bloqueado}}"
       },
       @endforeach
      
   ];
   //document.getElementById('monitor_reactivos_cerrrados').innerHTML='no se contstan:'+no_se_contestan+' aun no: '+aun_no;
   // console.log('aun no',aun_no);
   // console.log('reactivos:',reactivos);
   //En la seccion D, no se pregunta la imnportancia de los factores de contratacion si el egresado no es empleado (prof independiente, trabajador independiente, propietario)
   
   console.log(no_se_contestan);
   act_block();
   //Funciones Logicas y de bloqueo------------------------------------------------
   function dishable_reactive(react_name){
       // console.log('deshabilitar '+react_name);
       $("#"+react_name).children().prop('disabled', true);
       $("#"+react_name).css("background-color","#e6e6e6");
       $("#"+react_name).css("color","#a6a6a6");
       $("#"+react_name).value=' ';
       //top label (si es que existe)
       $("#"+react_name+'label').css("background-color","#e6e6e6");
       $("#"+react_name+'label').css("color","#a6a6a6");
       var cells = document.getElementsByClassName('op'+react_name); 
       for (var i = 0; i < cells.length; i++) { 
           cells[i].disabled = true;
       }
   
       var cells = document.getElementsByClassName(react_name+'opcion'); 
       for (var i = 0; i < cells.length; i++) { 
           cells[i].disabled = true;
       }
       var els = document.getElementsByClassName("cuadrito-"+react_name);
       Array.prototype.forEach.call(els, function(cuad) {
           cuad.style.backgroundColor = '#e6e6e6';
           cuad.style.color = '#a6a6a6';
       });
   }
   
   function hable_reactive(react_name){
       // console.log('habilitar '+react_name);
       if($("#"+react_name).children().prop('disabled')){
           var els = document.getElementsByClassName("cuadrito-"+react_name);
       Array.prototype.forEach.call(els, function(cuad) {
           cuad.style.backgroundColor = '#FFF';
           cuad.style.color = '#000';
       });
       }
       $("#"+react_name).children().prop('disabled', false);
       $("#"+react_name).css("background-color","#ffffff");
       $("#"+react_name).css("color","#000000");
       //top label (si es que existe)
       $("#"+react_name+'label').css("background-color","#ffffff");
       $("#"+react_name+'label').css("color","#000000");
       var cells = document.getElementsByClassName('op'+react_name); 
       for (var i = 0; i < cells.length; i++) { 
           cells[i].disabled = false;
       }
       var cells = document.getElementsByClassName(react_name+'opcion'); 
       for (var i = 0; i < cells.length; i++) { 
           cells[i].disabled = false;
       }
       
   }
   //act_block: bloquea todo lo que exista en los arreglos 'no se contestan' y 'aun no'
   function act_block(){
       @if($section=='D'&&in_array($Encuesta->ncr6,array(2,3,6))&&($Egresado->act_suvery!=1))
       console.log('pushing to no se contestan');
       if(!no_se_contestan.includes('ndr3')){
          no_se_contestan.push("ndr3",'ndr8','ndr4','ndr9','ndr5','ndr10','ndr6','ndr11','ndr7','ndr12','ndr12a','ndr12b','ndr12c','ndr13a'); 
       }
       @endif
       console.log('Actualizando--------------------');
       for (var i = 0; i < reactivos.length; i++) {
               if(no_se_contestan.includes(reactivos[i])||aun_no.includes(reactivos[i])){
                   dishable_reactive(reactivos[i]);
                  }else{
                   hable_reactive(reactivos[i])
               }
       }
       
   //document.getElementById('monitor_reactivos_cerrrados').innerHTML='no se contstan:'+no_se_contestan+' aun no: '+aun_no;
   }
   
   function optionWasClicked(react_name,for_block,involucrados,option_key=0){
       //funciona para deshabilitar el contenedor grande 
       if($("#"+react_name).children().prop('disabled')){
           return 0;
       }
       //eso es para que funcione igual si se da click en el circulito del input radio
       // o en el contenedor de la respuesta grande
       if(option_key!=0){
           document.getElementById(react_name+'op'+option_key).checked = true;
       }
       //Las respuestas no seleccionadas se colorean de blanco
       var els = document.getElementsByClassName("cuadrito-"+react_name);
       Array.prototype.forEach.call(els, function(el) {
           el.style.backgroundColor = '#FFFFFF';
           el.style.color = '#000000';
       });
       //Colorear el cuadro grande de la respuesta seleccionada de azul
       document.getElementById('cuadrito'+react_name+option_key).style.backgroundColor = '#002b7a';
       document.getElementById('cuadrito'+react_name+option_key).style.color = '#FFFFFF';
   
       //quitar de la lista de "aun no se contestan"
       if(aun_no.includes(react_name)){aun_no.splice(aun_no.indexOf(react_name),1);}
                    
       //si hay reactivos que deben bloquearse segun la opcion que se selecciono
       //entonces los agregamos a la lista de reactivos que no se contestan
       
           //primero hay que quitar (si hay alguno), los reactivos que pudieron haber sido bloqueados con otra opacion
           //y ahora que se selleciona una opcion de nuevo no debe haber ninguno del reactivo en ceustion
       
   
           if(involucrados.length>0){
           for (var i = 0; i < involucrados.length; i++) {
               if(no_se_contestan.includes(involucrados[i])){
                    no_se_contestan.splice(no_se_contestan.indexOf(involucrados[i]),1);
                   //  hable_reactive(involucrados[i]);
                  }
               }
               console.log('resetenadno lista de no contestar');
                  console.log('involucrados ',involucrados);
                  console.log('no se contestan ',no_se_contestan);
           }
           //si es que hay algo que bloquear lo hace
           console.log('agregando a no se contestan');
   //agregamos al if checar la pregunta nr1a
       if(for_block.length>0){
           for (var i = 0; i < for_block.length; i++) {
               if(for_block[i] !== 'ner1a' && !no_se_contestan.includes(for_block[i])){
                   no_se_contestan.push(for_block[i]);
               }
           
           }
       }
   
       find_next(react_name);
       
   
   
   }
   
   function find_next(react_name){
       last_index=reactivos.indexOf(react_name);
       last_index=last_index+1;
       reactivo_siguiente=reactivos[last_index];

       // Condición específica para nfr23
       if (react_name === 'nfr23') {
           var opciones = document.getElementsByClassName(react_name+'opcion'); 
           for (var i = 0; i < opciones.length; i++) {
            console.log('Opción ' + i + ' - checked:', opciones[i].checked);
               if (opciones[i].checked===true && opciones[i].id === 'nfr23op18') {
                console.log('Opción con valor 18 encontrada');
                if (no_se_contestan.includes('nfr24')) {
                    no_se_contestan.splice(no_se_contestan.indexOf('nfr24'), 1);
                    break;
                   }
               }
           }
       }
       
       console.log('start while');
       while((no_se_contestan.includes(reactivo_siguiente)) &&( last_index<reactivos.length)) {
           last_index=last_index+1;
           reactivo_siguiente=reactivos[last_index];
         }
   
         console.log('reactivo-siguiente',reactivo_siguiente);
      if(aun_no.includes(reactivo_siguiente)){
                    aun_no.splice(aun_no.indexOf(reactivo_siguiente),1);
                  }
       act_block();
       if(last_index>=reactivos.length){
           $("#final-button").removeAttr("disabled");
           var element = document.getElementById('final-button');
       }else{
           var element = document.getElementById(reactivo_siguiente+'-redact');
       }

   
   
       var ventana = document.getElementById('rlist');
       var elementPosition = element.getBoundingClientRect().top;
       console.log(element);  
       ventana.scrollTop= ventana.scrollTop+elementPosition-50-ventana.getBoundingClientRect().top;
   }


function optionWasSelected(react_name,involucrados){
   
   var val=document.getElementById('select-'+react_name).value;
   
   for_block = all_bloqueos.filter(item => item.valor == parseInt(val)).filter(item => item.clave_reactivo == react_name);
   console.log('reactivo: '+react_name);
   console.log('selected: ',val,for_block);
   last_index=reactivos.indexOf(react_name);
   last_index=last_index+1;
   reactivo_siguiente=reactivos[last_index];
   if(involucrados.length>0){
       for (var i = 0; i < involucrados.length; i++) {
           if(no_se_contestan.includes(involucrados[i])){
                no_se_contestan.splice(no_se_contestan.indexOf(involucrados[i]),1);
              }
           }
              console.log('resetenadno lista de no contestar');
              console.log(involucrados);
              console.log(no_se_contestan);
       }
       //quitar el propio reactivo de la lista de aun no
       if(aun_no.includes(react_name)){aun_no.splice(aun_no.indexOf(react_name),1);}
         
       console.log('agregando a no se contestan');
       console.log('por bloquear: ', for_block);
   if(for_block.length>0){
       for (var i = 0; i < for_block.length; i++){
           if(! no_se_contestan.includes(for_block[i])){
                   no_se_contestan.push(for_block[i].bloqueado);
               }
           }
       }
    find_next(react_name);
   }
   
   //se activa al dar enter o presionar el boton de una entrada de texto abierto o numerico
   function unblockNext(react_name){
       var element = document.getElementById(react_name+'label');
       element.classList.toggle("active");
       find_next(react_name);
   }
   
   
   function optionChecked(react_name,op,bloqueados){
    var element = document.getElementById(react_name+'label'); //elemento del reactivo
    var opciones=document.getElementsByClassName(react_name+'opcion'); //opciones asociadas al reactivo
    almenos_una_opcion=0;
    console.log(opciones);
    for(i=0;i<opciones.length;i++){
        console.log(opciones[i].checked);
        if(opciones[i].checked){
    
            almenos_una_opcion=1;
        }
    }

    //if para caso de nar3a

    if(react_name === 'nar3a') {
    for (var i = 0; i < opciones.length; i++){
        
        if(opciones[i].id === 'nar3aop1'){
            // Si 'nar3aop1' está seleccionada, bloquea las otras opciones
            if(opciones[i].checked === true){
                for(var j = 0; j < opciones.length; j++){
                    // Evitar bloquear la opción 'nar3aop1' misma
                    if(opciones[j].id !== 'nar3aop1'){
                        // Desmarcar otras opciones seleccionadas
                        if(opciones[j].checked === true){
                            opciones[j].checked = false;
                        }
                        // Bloquear otras opciones
                        opciones[j].disabled = true;
                    }
                }
            } 
            // Si 'nar3aop1' NO está seleccionada, desbloquea las otras opciones
            else {
                for(var j = 0; j < opciones.length; j++){
                    
                    if(opciones[j].id !== 'nar3aop1'){
                        opciones[j].disabled = false;
                    }
                }
            }
            break;
        }
    }
}

    //checa si es que hay una opcion seleccionada
    if(almenos_una_opcion){
        //quitar el propio reactivo de la lista de aun no
        if(aun_no.includes(react_name)){aun_no.splice(aun_no.indexOf(react_name),1);}
            
        if( !element.classList.contains('active')){
            element.classList.toggle("active");
            element.disabled=false;
        }
    }else{
        if( element.classList.contains('active')){
            element.classList.toggle("active");
            element.disabled=true;
        }
    }

    //opciones bloqueadas
    if(bloqueados.length>0){
        if(document.getElementById(react_name+'op'+String(op)).checked){
            
            for (var j = 0; j < bloqueados.length; j++) {
                if(! no_se_contestan.includes(bloqueados[j])){
                    no_se_contestan.push(bloqueados[j]);
                }
            }
            
            }else{
                
                for (var j = 0; j < bloqueados.length; j++) {
                if(no_se_contestan.includes(bloqueados[j])){
                    no_se_contestan.splice(no_se_contestan.indexOf(bloqueados[j]),1);
                    
                    }
                }
                
            
            }     
    }

   }
   
   function submitForm(){
       
   
       for (var i = 0; i < no_se_contestan.length; i++) {
           console.log('cambiando valores',no_se_contestan[i]);
           document.getElementsByName(no_se_contestan[i])[0].value="0";
           }
       $("#main_form").submit();
   }
   
   //Funciones esteticas y visuales--------------------------------------------
   function showlabel(id){
       console.log('showing.label')
    var element = document.getElementById(id);
     element.classList.toggle("active");
   
      }
</script>