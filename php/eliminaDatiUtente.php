<?php

session_start();
include("funzioniQuery.php");
$immaginiUtente = ottieniImmaginiUtente($_SESSION["id"]);
$immagineProfilo = $immaginiUtente["immagine_profilo"];
$bannerProfilo = $immaginiUtente["banner_profilo"];
if($immagineProfilo != ""){
    unlink("../uploads/".$immagineProfilo);
}
if($bannerProfilo != ""){
    unlink("../uploads/".$bannerProfilo);
}

$esito = eliminaUtente($_SESSION["id"]);
if($esito){
    session_destroy();
    session_unset();
    header("location:../index.html");
}else{
    header("location:../home/profilo/eliminaProfilo.php");
}


?>