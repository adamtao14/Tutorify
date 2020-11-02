
    $("#listaScuole").hide(); 
    $("#scuola").keyup(function () {
        var query = $(this).val();
        if (query != "") {
            $.ajax({
                url: "../../php/cercaScuola.php",
                method: "POST",
                data: {query: query},
                success: function (data) {
                    $("#listaScuole").fadeIn();
                    $("#listaScuole").html(data);
                }
            });
        }else{
            $("#listaScuole").fadeOut();
        }
    });
    $(document).on("click", ".ElementoScuola", function () {
        $("#scuola").val($(this).text());
        $("#listaScuole").fadeOut(); 
    });
