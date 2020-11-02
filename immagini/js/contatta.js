var modalContatta = document.getElementById("contatta");

$("#pulsanteContatta").click(function() {
  $("#contatta").fadeIn(500);
});


$("#chiudiContatta").click(function() {
  $("#contatta").fadeOut(500);
});

window.onclick = function(event) {
  if (event.target == modalContatta) {
    $("#contatta").fadeOut(500);
  }
}