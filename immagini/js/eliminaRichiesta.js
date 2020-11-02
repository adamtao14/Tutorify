function eliminaRichiesta(idRichiesta, id){
    return $.ajax({
        url: "../../php/eliminaRichiesta.php",
        method: "POST",
        data: {
            idRichiesta: idRichiesta
        },
        success: function (data) {
            console.log(data);
           if(data == 1){
               document.getElementById("richiesta"+id).style.display="none";
           }
        }
    });
}