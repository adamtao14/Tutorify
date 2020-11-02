jQuery(".materie_utente").draggable({ 
    cursor: "move", 
    containment: "parent",
    stop: function() {
      if(jQuery(".materie_utente").position().left < 1)
          jQuery(".materie_utente").css("left", "720px");
    }
});