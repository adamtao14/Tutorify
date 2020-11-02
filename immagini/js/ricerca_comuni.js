$(document).ready(function () {
    $("#listaComuni").hide(); 
    $("#comune").keyup(function () {
        var query = $(this).val();
        if (query != "") {
            $.ajax({
                url: "../php/cercaComune.php",
                method: "POST",
                data: {query: query},
                success: function (data) {
                    $("#listaComuni").fadeIn();
                    $("#listaComuni").html(data);
                }
            });
        }else{
            $("#listaComuni").fadeOut();
        }
    });
    $(document).on("click", "li", function () {
        $("#comune").val($(this).text());
        $("#listaComuni").fadeOut(); 
    });
});