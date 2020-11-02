<?php
session_start();
include("funzioniQuery.php");
include("funzioniFile.php");
require("controlloDati.php");
$errori = "";
$idStudente = $_SESSION["id"];
$nome = $_POST["nome"];
$cognome = $_POST["cognome"];
$comune = $_POST["comune"];
$scuola = $_POST["scuola"];
$classe = $_POST["classe"];
$indirizzo = $_POST["indirizzo"];
$dataNascita = $_POST["dataNascita"];
$descrizione = $_POST["descrizione"];
$telefono = $_POST["telefono"];


$idScuolaScelta = cercaIdScuola($scuola);
$idClasseScelta = cercaIdClasse($classe);
$idIndirizzoScelto = cercaIdIndirizzoScelto($indirizzo);
$idResidenzaScelta = cercaIdResidenza($comune);
$esistenzaTelefono = 0;
if($telefono != ""){
    if($telefono != $_SESSION["telefono"]){
        $esistenzaTelefono = esistenzaTelefono($telefono);
    }
}



if ($idScuolaScelta == null) {
    caricaScuola($scuola);
}
$nome = test_input($nome);
$cognome = test_input($cognome);

$esitoUpdateTelefono = 0;

$esitoUpdateNomeCognome = updateNomeCognome($nome, $cognome, $idStudente);
$esitoUpdateClasse = updateClasse($idClasseScelta, $idStudente);
$esitoUpdateDescrizione = updateDescrizione($descrizione, $idStudente);
$esitoUpdateIndirizzo = updateIndirizzo($idIndirizzoScelto, $idStudente);
$esitoUpdateScuola = updateScuola($idScuolaScelta, $idStudente);
$esitoUpdateDataNascita = updateDataNascita($dataNascita, $idStudente);
$esitoUpdateComune = updateComune($idResidenzaScelta, $idStudente);
if(!$esistenzaTelefono){
    $esitoUpdateTelefono = updateNumero($telefono,$idStudente);
}else{
    $errori .= "<p class='erroreScritta'>Il telefono è già in uso</p>"; 
}


if (!$esitoUpdateTelefono) {
    $errori .= "<p class='erroreScritta'>Il telefono non è stata cambiato</p>";
}
if (!$esitoUpdateClasse) {
    $errori .= "<p class='erroreScritta'>La classe non è stata cambiata</p>";
}
if (!$esitoUpdateNomeCognome) {
    $errori .= "<p class='erroreScritta'>Il nome e cognome non sono stati cambiati</p>";
}
if (!$esitoUpdateDescrizione) {
    $errori .= "<p class='erroreScritta'>La descrizione non è stata cambiata</p>";
}
if (!$esitoUpdateIndirizzo) {
    $errori .= "<p class='erroreScritta'>L'indirizzo non è stato cambiato</p>";
}
if (!$esitoUpdateDataNascita) {
    $errori .= "<p class='erroreScritta'>La data di nascita non è stata cambiata</p>";
}
if (!$esitoUpdateScuola) {
    $errori .= "<p class='erroreScritta'>La scuola non è stata cambiata</p>";
}
if (!$esitoUpdateComune) {
    $errori .= "<p class='erroreScritta'>Il comune non è stato cambiato</p>";
}
$contaMaterieNonAggiunte = 0;
if (isset($_POST["materie"])) {
    $numeroMaterie = count($_POST["materie"]);

    for ($i = 0; $i < $numeroMaterie; $i++) {
        $idMateriaScelta = cercaIdMateriaScelta($_POST["materie"][$i]);
        $esistenza = esistenzaMateriaUtente($idStudente, $idMateriaScelta);
        if (!$esistenza) {
            $ris = aggiungiMateriaStudente($idMateriaScelta, $idStudente);
            if (!$ris) {
                $contaMaterieNonAggiunte++;
            }
        }

    }
}
if ($contaMaterieNonAggiunte != 0) {
    if ($contaMaterieNonAggiunte == 1) {
        $errori .= "<p class='erroreScritta'>".$contaMaterieNonAggiunte . " delle materie scelte non aggiunta</p>";
    } else {
        if ($contaMaterieNonAggiunte == 1) {
            $errori .= "<p class='erroreScritta'>".$contaMaterieNonAggiunte . " delle materie scelte non aggiunte</p>";
        }
    }
}

$output = "";
if ($errori == "") {
    $_SESSION["nome"] = $nome;
    $_SESSION["cognome"] = $cognome;
    $_SESSION["comune"] = $comune;
    $_SESSION["num_classe"] = $classe;
    $_SESSION["nome_indirizzo"] = $indirizzo;
    $_SESSION["descrizione"] = $descrizione;
    $_SESSION["scuola"] = $scuola;
    $_SESSION["data_nascita"] = $dataNascita;
    $output = "
        <p id='titolo'>Profilo modificato con successo </p>
        <img src='../immagini/modificaRiuscita.svg' />
        <a href='../home/profilo/profilo.php'>Torna al profilo</a>
    ";
} else {
    $output = "<p id='titolo'>Ops qualcosa è andato storto :( </p>";
    $output .= $errori;
    $output .= "<br><br><a href='../home/profilo/profilo.php'>Torna al profilo</a>";
    
}
$html = "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <script src='https://code.jquery.com/jquery-3.4.1.min.js' integrity='sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=' crossorigin='anonymous'></script>
    <link href='https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js'></script>
    <link rel='stylesheet' href='../css/queryStudenti.css'>
    <link rel='stylesheet' href='../css/navbar.css'>
    <link rel='stylesheet' href='../css/animate.css'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Profilo di {$_SESSION["nome"]}</title>
</head>
<body>
    <div class='contenitore-errore'>
    {$output}
    </div>
</body>
</html>
    ";
print($html);







?>