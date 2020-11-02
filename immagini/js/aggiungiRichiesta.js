$(document).ready(function () {

    $("#richiesta").click(function () {
        var descrizione = $("#descrizioneRichiesta").val();
        var materia = $("#listaMaterieRichiesta option:selected").text();
        var provincia = $("#listaProvince option:selected").text();
            $.ajax({
                url: "../php/aggiungiRichiesta.php",
                method: "POST",
                data: {
                    descrizione: descrizione,
                    materia: materia,
                    provincia: provincia
                },
                success: function (data) {
                    $("#chiudi").trigger("click");
                    $("html, body").animate({scrollTop: 0}, 500);
                    if(data == 0){
                        $("#ricNonCaricata").fadeIn();
                        setTimeout(
                            function() 
                            {
                                $("#ricNonCaricata").fadeOut("slow");
                            }, 2000);
                    }
                    if(data == 1){
                        $("#ricCaricata").fadeIn();
                        setTimeout(
                            function() 
                            {
                                $("#ricCaricata").fadeOut("slow");
                            }, 2000);
                    }
                    if(data == 2){
                        $("#ricEsistente").fadeIn();
                        setTimeout(
                            function() 
                            {
                                $("#ricEsistente").fadeOut("slow");
                            }, 2000);
                    }
                    
                },
                error: function(){
                    $("#ricNonCaricata").fadeIn();   
                    setTimeout(
                        function() 
                        {
                            $("#ricNonCaricata").fadeOut("slow");
                        }, 2000); 
                }
            });

    });

});