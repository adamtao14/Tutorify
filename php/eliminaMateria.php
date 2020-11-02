<?php

include("funzioniQuery.php");
session_start();
$materiaDaEliminare = $_POST["materia"];
$idStudente = $_SESSION["id"];
$idMateria = ottieniIdMateria($materiaDaEliminare);
$esito = eliminaMateriaStudente($idStudente,$idMateria);
$materieRimaste = ottieniMaterieStudenti($idStudente);
if($materieRimaste=""){
    $_SESSION["materie"] = "Nessuna materia selezionata";
}else{
    $_SESSION["materie"] = $materieRimaste;
}
print($esito);






?>