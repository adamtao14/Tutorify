$(document).ready(function () {

            $.ajax({
                url: "php/datiHome.php",
                data: {},
                success: function (data) {
                    var risultatiSplittati = data.split("-");
                    document.getElementById("numeroUtenti").innerHTML = risultatiSplittati[0];
                    document.getElementById("numeroRecensioni").innerHTML = risultatiSplittati[1];
                    document.getElementById("numeroMaterie").innerHTML = risultatiSplittati[2];
                    document.getElementById("numeroProvince").innerHTML = risultatiSplittati[3];
                },
                error: function(){
                    document.getElementById("numeroUtenti").innerHTML = 0;
                    document.getElementById("numeroRecensioni").innerHTML = 0;
                    document.getElementById("numeroMaterie").innerHTML = 0;
                    document.getElementById("numeroProvince").innerHTML = 0;
                }
            });

});