var modal = document.getElementById("recensione");
var close = document.getElementsByClassName("closebtn");
var i;



$("#pulsanteRecensione").click(function() {
  $("#recensione").fadeIn(500);
});


$("#chiudi").click(function() {
  $("#recensione").fadeOut(500);
});

window.onclick = function(event) {
  if (event.target == modal) {
    $("#recensione").fadeOut(500);
  }
}