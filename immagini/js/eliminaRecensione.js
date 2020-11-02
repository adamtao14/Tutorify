

    function eliminaRecensione(id){
        var conferma = confirm("Sei sicuro di volere cancellare la tua recensione?");
        if(conferma){
            var idRecensione = id;
            $.ajax({
                url: "../php/eliminaRecensione.php",
                method: "POST",
                data: {
                    idRecensione: idRecensione
                },
                success: function (data) {
                    console.log(data);
                    $("html, body").animate({scrollTop: 0}, 500);
                    if(data == 0){
                        $("#recNonEliminata").fadeIn();
                        setTimeout(
                            function() 
                            {
                                $("#recNonEliminata").fadeOut("slow");
                            }, 2000);
                    }
                    if(data == 1){
                        $("#recEliminata").fadeIn();
                        setTimeout(
                            function() 
                            {
                                $("#recEliminata").fadeOut("slow");
                            }, 2000);
                    }
                    
                },
                error: function(){
                    $("#recNonEliminata").fadeIn(); 
                    setTimeout(
                        function() 
                        {
                            $("#recNonEliminata").fadeOut("slow");
                        }, 2000);   
                }
                
            });
        }

        
        

    }

