<?php

include("funzioniQuery.php");
session_start();
$idRecensione = $_POST["idRecensione"];
$flagEsito = 0;
$esito = eliminaRecensioni($idRecensione);
if($esito){
    $flagEsito = 1;
}else{
    $flagEsito = 0;
}
print($flagEsito);






?>