$(document).ready(function () {
    $("#errore").hide();
    $("#errore-due").hide();  
    $("#pulsanteElimina").on("click",function () {
        var password = $("#password").val();
        if (password != "") {
            $.ajax({
                url: "../../php/controlloPasswordEliminazione.php",
                method: "POST",
                data: {
                    password: password
                },
                success: function (data) {
                    if(data == "0"){
                        $("#errore").show();   
                    }else{
                        $.ajax({
                            url: "../../php/eliminaDatiUtente.php",
                            method: "POST",
                            data: {},
                            success: function (data) {
                                window.location.assign("../../login/accedi.php");
                            },
                            error: function (data){
                               
                            }
                        }); 
                    }
                },
                error: function (data){
                    $("#errore-due").show();  
                }
            });
        }else{
            $("#errore").show();   
        }
    });
});