function triggerImmagineBanner(){
    document.querySelector("#immagine_banner").click();
}
function triggerImmagineFotoProfilo(){
    document.querySelector("#immagine_foto_profilo").click();
}
function visualizzaBanner(e){
    if(e.files[0]){
        var reader = new FileReader();

        reader.onload = function(e){
            document.querySelector('#banner_profilo').style.backgroundImage = "url('"+e.target.result+"')" ;
        }
        reader.readAsDataURL(e.files[0]);
    }
}
function visualizzaFotoProfilo(e){
    if(e.files[0]){
        var reader = new FileReader();

        reader.onload = function(e){
            document.querySelector('#immagine_profilo').style.backgroundImage = "url('"+e.target.result+"')" ;
        }
        reader.readAsDataURL(e.files[0]);
    }
}