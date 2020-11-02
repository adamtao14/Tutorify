var modalValutazione = document.getElementById("valutazione");
var close = document.getElementsByClassName("closebtn");
var slider = document.getElementById("rangeValutazione");
var output = document.getElementById("demo");


$("#pulsanteRecensione").click(function() {
  $("#valutazione").fadeIn(500);
});


$("#chiudiValutazione").click(function() {
  $("#valutazione").fadeOut(500);
});

window.onclick = function(event) {
  if (event.target == modalValutazione) {
    $("#valutazione").fadeOut(500);
  }
}
output.innerHTML = slider.value;

slider.oninput = function() {
  output.innerHTML = this.value;
}