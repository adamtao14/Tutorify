<?php

session_start();
$output = "";
if (isset($_GET["err"])) {
    $output = "
    <div class='isa_error' id='isa_error'>
        <i class=' fa fa - times - circle '></i>
        <strong>Errore</strong><br>
        <br>
            {$_SESSION["registrazioneMesaggioErrori"]}
            <p id='chiudi'>&#x274C;</p>   
    </div>
    ";
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='initial-scale=1, viewport-fit=cover'>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel='shortcut icon' href='../immagini/favicon.ico'/>
    <link rel='shortcut icon' href='http://tutorify.it/immagini/favicon.ico'/>
    <title>Registrati a Tutorify</title>
    <link rel="stylesheet" href="../css/registrati.css">
    <link rel="stylesheet" href="../css/animate.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
    
    <div class="container-login animated zoomIn">
    <?php print($output); ?>
        <div class="parte-login">
            <h2 class="animated zoomIn">Registrati</h2>
            <form action="../php/registratiCheck.php" method="POST">
                <input type="text" name="nome" placeholder="Nome" class="animated zoomIn inlinea" id="nome" required/>
                <input type="text" name="cognome" placeholder="Cognome" class="animated zoomIn inlinea" id="cognome" required/>
                <input type="text" name="email" placeholder="Email" class="animated zoomIn inlinea" id="email" required/>
                <input type="text" name="telefono" placeholder="Telefono (opzionale)" class="animated zoomIn inlinea" id="telefono"/>
                <p>Data di nascita</p>
                <input type="date" name="dataNascita" value="2001-01-01"  class="animated zoomIn" id="datanascita" required/>
                <input type="text" name="residenza" placeholder="Comune di Residenza" id="comune" class="animated zoomIn" autocomplete="off" required/>
                <div id="listaComuni" class="animated zoomIn">

                </div>
                <input type="password" name="password" placeholder="Password" class="animated zoomIn inlinea" id="password" required/>
                <input type="password" name="confPassword" placeholder="Conferma password" class="animated zoomIn inlinea" id="passwordConf" required/>
                <input type="checkbox" id="checkDati" name="check" required>Ho letto e acconsento alla privacy policy
                <input type="submit" name="submit" class="animated zoomIn" value="Registrati" />

            </form>

            <a href="../login/accedi.php">Accedi</a>
            <a href="../privacy/privacy.html">Privacy Policy</a>
            <a href="../index.html" id="dati-dimenticati">Torna in home</a>
        </div>

    </div>
    <script src="../js/ricerca_comuni.js"></script>
    <script src="../js/chiudiErrore.js"></script>
</body>

</html>