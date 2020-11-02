<?php


// Questo file permette di cercare il proprio comune reperendolo dal database dalla tabella residenza

session_start();
include("funzioniQuery.php");
include("funzioniRicercaStudenti.php");
$query = $_POST["query"];
$risultato = queryStudentiRicercaNavbar($query);
$fileCorrente =  $_POST["filename"];
$lista = "<ul>";
$baseFile = "";

switch($fileCorrente){
    case "dashboard.php":
        $baseFile = "../php/studente.php";
        break;
    case "richieste.php":
        $baseFile = "studente.php";
        break;
    case "profilo.php":
        $baseFile = "../../php/studente.php";
        break;
    case "modificaProfilo.php":
        $baseFile = "../../php/studente.php";
        break;
    case "studente.php":
        $baseFile = "studente.php";
        break;
    case "queryStudenti.php":
        $baseFile = "studente.php";
        break;
    case "richieste.php":
        $baseFile = "studente.php";
        break;
    case "classifica.php":
        $baseFile = "../php/studente.php";
        break;
    case "eliminaProfilo.php":
            $baseFile = "../../php/studente.php";
            break;
    default:
        break;
}
if(count($risultato)>0){
    for($i = 0; $i < count($risultato); $i++){
        $lista .= "<li><a href='".$baseFile."?id=".$risultato[$i]["ID"]."'>".$risultato[$i]["nome"]." ".$risultato[$i]["cognome"]."</a></li>";
    }
}else{
    $lista .="Non abbiamo trovato risultati";
}

$lista .="</ul>";
print($lista);



?>