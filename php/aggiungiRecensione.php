<?php
session_start();
include("funzioniQuery.php");

$idStudenteRecensito = $_POST["idStudente"];
$descrizione = $_POST["descrizione"];
$valutazione = $_POST["valutazione"];
$dataCorrente = date("Y-m-d");
$idStudenteRecensore = $_SESSION["id"];
$flagFinale = 0; //flag che indica lo stato della recensione
$controlloEsistenzaRecensione = controlloEsistenzaRecensione($idStudenteRecensito,$idStudenteRecensore);
if($controlloEsistenzaRecensione){
    $flagFinale = 2;
}else{
    $esito = aggiungiRecensione($idStudenteRecensito,$idStudenteRecensore,$valutazione,$descrizione,$dataCorrente);
    if($esito){

        $flagFinale = 0;
    
    }else{
        
        $flagFinale = 1;
    }
}


print($flagFinale);


?>