<?php

session_start();
include("../../php/sessionExpiration.php");
if (isset($_SESSION["id"])) {
  if (isLoginSessionExpired()) {
      header("Location:../../logout/logout.php?sessione_scaduta=1");
  } else {
      if ($_SESSION["profilo_completato"] == 0) {
        header("Location:../../completamento/completaRegistrazione.php");
      }
  }
} else {
  header("Location:../../login/accedi.php");
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta name='viewport' content='initial-scale=1, viewport-fit=cover'>
  <script src="https://kit.fontawesome.com/50313730dd.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../../css/eliminaProfilo.css">
  <link rel="stylesheet" href="../../css/navbar.css">
  <link rel="stylesheet" href="../../css/footer.css">
  <script src='//code.jquery.com/jquery-1.10.2.js'></script>
  <link rel='shortcut icon' href='../immagini/favicon.ico'/>
  <link rel='shortcut icon' href='http://tutorify.it/immagini/favicon.ico'/>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Elimina profilo</title>
</head>

<body>

<div class="navbar" id="navbar">
  <a href="../dashboard.php" class="active align-left" id="logo">TUTORIFY</a>

  <div class="dropdown">
      <button class="dropbtn"><?php print($_SESSION["nome"]); ?> 
      &#9662;
      </button>
      <div class="dropdown-content">
          <a href="../classifica.php">Classifica </a>
          <a href="profilo.php">Profilo </a>
          <a href="../../logout/logout.php" class="logoutButton">Logout</a>
      </div>
  </div>

  <a href="../../php/richieste.php" class="align-right">Richieste</a>
  <a id="contenitore-ricerca">
      <div class="barra_ricerca">
          <form>
              <input type="text" id="cercaUtenti" placeholder="Cerca studenti..." autocomplete="off"/>
              <button type="submit" id="pulsanteCercaUtenti"><i class="fa fa-search"></i></button>
          </form><br>
          <div id="listaUtenti">
          
          </div>
      </div>
  </a>
  <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="responsive()">&#9776;</a>
</div>
  <div class="contenitore">

  <p id="titolo">Ci dispiace vederti andare <?php print($_SESSION["nome"]);?></p>
  <img src="../../immagini/eliminazioneUtente.svg"/>
  <p id="disclaimer">Una volta eliminato il tuo profilo perderai tutte le richieste che hai fatto</p>
  <p id="disclaimer-due">Inserisci la tua password prima di procedere all'eliminazione</p>
  <input type="password" id="password" placeholder=""/>
  <p id="errore">Password errata,riprova</p>
  <p id="errore-due">Qualcosa è andato storto,riprova</p>
  <button id="pulsanteElimina">Elimina</button>
  </div>

  <footer class="footer-distributed">

    <div class="footer-right">

      <a href="#"><i class="fa fa-facebook"></i></a>
      <a href="#"><i class="fa fa-twitter"></i></a>
      <a href="#"><i class="fa fa-linkedin"></i></a>

    </div>

    <div class="footer-left">

      <p class="footer-links">
        <a class="link-1" href="../../index.html">Home</a>

        <a href="../../privacy/privacy.html">Privacy</a>

        <a href="../../contact/contattaci.html">Contattaci</a>
      </p>

      <p>TUTORIFY &copy; 2020</p>
    </div>

  </footer>
  <script src="../../js/responsive.js"></script>
  <script src="../../js/ricercaUtenti.js"></script>
  <script src="../../js/eliminaUtente.js"></script>
</body>

</html>