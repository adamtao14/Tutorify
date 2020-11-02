$(document).ready(function () {
    var url = window.location.pathname;
    var filename = url.substring(url.lastIndexOf('/')+1);
    if(filename == "modificaProfilo.php" || filename == "profilo.php" || filename == "eliminaProfilo.php"){
        urlLink = "../../php/cercaUtenti.php";
    } else{
        urlLink = "../php/cercaUtenti.php";
    }
    $("#listaUtenti").hide(); 
    $("#cercaUtenti").keyup(function () {
        var query = $(this).val();
        if (query != "") {
            $.ajax({
                url: urlLink,
                method: "POST",
                data: {
                    query: query,
                    filename: filename
                },
                success: function (data) {
                    $("#listaUtenti").fadeIn();
                    $("#listaUtenti").html(data);
                }
            });
        }else{
            $("#listaUtenti").fadeOut();
        }
    });
    $(document).on("click", "li", function () {
        $("#comune").val($(this).text());
        $("#listaUtenti").fadeOut(); 
    });
});