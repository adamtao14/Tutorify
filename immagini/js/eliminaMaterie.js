function eliminaMateria(id,materia){
    return $.ajax({
        url: "../../php/eliminaMateria.php",
        method: "POST",
        data: {
            materia: materia
        },
        success: function (data) {
            console.log(data);
           if(data == 1){
               document.getElementById("materia"+id).style.display="none";
           }
        }
    });
}