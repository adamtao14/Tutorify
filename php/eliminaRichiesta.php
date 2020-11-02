<?php

include("funzioniQuery.php");
session_start();
$idRichiesta = $_POST["idRichiesta"];
$idStudente = $_SESSION["id"];
$esito = eliminaRichiestaStudente($idStudente,$idRichiesta);
print($esito);






?>