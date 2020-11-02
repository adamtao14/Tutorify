<?php
session_start();
include("funzioniQuery.php");

$provincia = $_POST["provincia"];
$materia = $_POST["materia"];
$descrizione = $_POST["descrizione"];

$idStudente = $_SESSION["id"];
$idProvincia = ottieniIdProvincia($provincia);
$idMateria = ottieniIdMateria($materia);
$dataCorrente = Date("Y-m-d");
$esistenzaRichiesta = controlloEsistenzaRichiesta($idStudente, $idMateria, $descrizione, $idProvincia, $dataCorrente);
if (!$esistenzaRichiesta) {

    $esitoCaricamento = aggiungiRichiesta($idStudente, $idMateria, $descrizione, $idProvincia, $dataCorrente);

    if ($esitoCaricamento) {
        print("1");
    } else {
        print("0");
    }
}else{
    print("2");
}




?>