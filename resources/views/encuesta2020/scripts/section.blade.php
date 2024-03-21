<script>
// TODO:
//     1: deshabilitar todos los reactivos salvo el primero
//             -como saber cual es el primero :O
//     2: al contestar, habilitar sig, scroll
var reactivos=[@foreach($Reactivos as $r)'{{$r->clave}}', @endforeach];
//reactivos que no se contestan
var no_se_contestan=[];

console.log(reactivos)

function showlabel(id){
    console.log('showing.label')
 var element = document.getElementById(id);
  element.classList.toggle("active");
}

function dishable_reactive(react_name){
    console.log('deshabilitar '+react_name);
    $("#"+react_name).children().prop('disabled', true);
    // $("#"+react_name).css("background-color","#c6c6c6");
    $("#"+react_name).css("color","#a6a6a6");
    // document.getElementsByName(react_name)[0].value="0";
    var cells = document.getElementsByClassName('op'+react_name); 
    for (var i = 0; i < cells.length; i++) { 
        cells[i].disabled = true;
    }
}
function hable_reactive(react_name){
    
    console.log('habilitar '+react_name);
    $("#"+react_name).children().prop('disabled', false);
    // $("#"+react_name).css("background-color","#ffffff");
    $("#"+react_name).css("color","#000000");
    // if(document.getElementsByName(react_name)[0].value=="0"){
    //     document.getElementsByName(react_name)[0].value="";
    // }
    var cells = document.getElementsByClassName('op'+react_name); 
    for (var i = 0; i < cells.length; i++) { 
        cells[i].disabled = false;
    }
}

function optionWasClicked(react_name,for_block,involucrados){
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
    const element = document.getElementById('final-button');
    element.scrollIntoView();
    }else{
    hable_reactive(reactivo_siguiente);
    const element = document.getElementById(reactivo_siguiente);
    element.scrollIntoView();
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

    if(last_index>=reactivos.length){
    $("#final-button").removeAttr("disabled");
    }else{
    hable_reactive(reactivo_siguiente);
    const element = document.getElementById(reactivo_siguiente);
    element.scrollIntoView();}
    

}

function submitForm(){
    for (var i = 0; i < no_se_contestan.length; i++) {
        document.getElementsByName(no_se_contestan[i])[0].value=0;
        console.log('cambiando valores',no_se_contestan[i]);
        }

    $("#main_form").submit();
}

for (var i = 1; i < reactivos.length; i++) { dishable_reactive(reactivos[i]);}

</script>
