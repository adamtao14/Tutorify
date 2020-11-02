$(document).ready(function () {

    $("#valuta").click(function () {
        var urlParams = new URLSearchParams(window.location.search);
        var valutazione = $("#rangeValutazione").val();
        var descrizione = $("#descrizioneRecensione").val();
        var idStudenteRecensito = urlParams.get('id');
            $.ajax({
                url: "../php/aggiungiRecensione.php",
                method: "POST",
                data: {
                    descrizione: descrizione,
                    valutazione: valutazione,
                    idStudente: idStudenteRecensito
                },
                success: function (data) {
                    console.log(data);
                    $("#chiudiValutazione").trigger("click");
                    $("html, body").animate({scrollTop: 0}, 500);
                    if(data == 1){
                        $("#recNonCaricata").fadeIn();
                        setTimeout(
                            function() 
                            {
                                $("#recNonCaricata").fadeOut("slow");
                            }, 2000);
                    }
                    if(data == 0){
                        $("#recCaricata").fadeIn();
                        setTimeout(
                            function() 
                            {
                                $("#recCaricata").fadeOut("slow");
                            }, 2000);
                    }
                    if(data == 2){
                        $("#recEsistente").fadeIn();
                        setTimeout(
                            function() 
                            {
                                $("#recEsistente").fadeOut("slow");
                            }, 2000);
                    }
                    
                },
                error: function(){
                    $("#recNonCaricata").fadeIn(); 
                    setTimeout(
                        function() 
                        {
                            $("#recNonCaricata").fadeOut("slow");
                        }, 2000);   
                }
            });

    });

});