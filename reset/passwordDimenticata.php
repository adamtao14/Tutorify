<?php

session_start();
$output="";
$emailRicevuta="";
if (isset($_GET["err"])) {
    $variabileErrore="";
    if($_GET["err"]==1){
        $variabileErrore = $_SESSION["erroreResetEmail"];
    }else if($_GET["err"]==2){
        $variabileErrore = $_SESSION["erroreInvioEmailResetPassword"];
    }
    $output = "
    <div class='isa_error' id='isa_error'>
        <i class=' fa fa - times - circle '></i>
        <strong>Errore</strong><br>
        <br>
            {$variabileErrore}
         <p id='chiudi'>&#x274C;</p>  
    </div>
    ";
    if(isset($_GET["email"])){
        $emailRicevuta = $_GET["email"];
    }
}else{
    if(isset($_GET["sessione_scaduta"])){
        $output = "
    <div class='isa_warning' id='isa_error'>
        <i class=' fa fa - times - circle '></i>
        <strong>Errore</strong><br>
        <br>
            Sessione scaduta,accedi di nuovo!
         <p id='chiudi'>&#x274C;</p>   
    </div>
    ";
}
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name='viewport' content='initial-scale=1, viewport-fit=cover'>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="../immagini/favicon.ico"/>
    <link rel="shortcut icon" href="http://tutorify.it/immagini/favicon.ico"/>
    <link rel="stylesheet" href="../css/passwordDimenticata.css">
    <link rel="stylesheet" href="../css/animate.css">
    <title>Recupero password</title>
</head>

<body>
    <div class="container-login animated zoomIn">
        <?php print($output); ?>
        <div class="parte-login">
            <h2 class="animated zoomIn">Recupero password</h2>
            <form action="../php/resetPasswordCheck.php" method="POST">
                <input type="text" name="email" placeholder="Email" value="<?php print($emailRicevuta); ?>" class="animated zoomIn" required/>
                <br>
                <input type="submit" name="submit" class="animated zoomIn" value="Invia"/>
                <a href="../index.html" id="dati-dimenticati">Torna in home</a>
            </form>
        </div>

    </div>
    <script src="../js/chiudiErrore.js"></script>
</body>

</html>