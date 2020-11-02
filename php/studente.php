<?php
session_start();
include("profiloStudenteCercato.php");
include("funzioniQuery.php");
include("sessionExpiration.php");

if (isset($_SESSION["id"])) {
    if (isLoginSessionExpired()) {
        header("Location:../logout/logout.php?sessione_scaduta=1");
    }
}else{
    header("Location:../login/accedi.php");
}
$idStudente = $_GET["id"];
if($idStudente == $_SESSION["id"]){
    header("Location:../home/profilo/profilo.php");
}
$nomeFile = basename($_SERVER['PHP_SELF']);
$datiStudente = ottieniDatiStudente($idStudente);

if(count($datiStudente) > 0){
    $datiStudente = $datiStudente[0];
    if($datiStudente["immagine_profilo"] == ""){
        $immagineProfilo = "../home/profilo/immagini_default/default_profilo.jpg";
    }else{
        $immagineProfilo = "../uploads/".$datiStudente["immagine_profilo"];
    }
    if($datiStudente["banner_profilo"] == ""){
        $bannerProfilo = "../home/profilo/immagini_default/default_banner.jpg";
    }else{
        $bannerProfilo = "../uploads/".$datiStudente["banner_profilo"];
    }
    $nome = $datiStudente["nome"];
    $cognome = $datiStudente["cognome"];
    $comune = $datiStudente["nome_comune"];
    $numClasse = $datiStudente["num_classe"];
    $nomeIndirizzo = $datiStudente["nome_indirizzo"];
    $descrizione = $datiStudente["descrizione"];
    $email = $datiStudente["email"];
    $telefono = $datiStudente["telefono"];
    $eta = calcolaEta($datiStudente["data_nascita"]);
    $materieStudente = ottieniMaterieStudenti($idStudente);
    $scuola = ottieniStudenteScuola($idStudente);
    $scuola = $scuola[0]["nome"];
    $recensioniStudente = ottieniRecensioni($idStudente);
    $numeroRecensioni = count($recensioniStudente);
    $recensioniHtml = creaRecensioni($recensioniStudente, $nomeFile);
    $html = creaPaginaProfiloStudenteCercato($nome,$cognome,$immagineProfilo,$bannerProfilo,$numClasse,$comune,$scuola,$descrizione,$eta,$nomeIndirizzo,$materieStudente,$idStudente,$recensioniHtml,$numeroRecensioni,$telefono,$email);
    
}else{
    //bisogna fare una pagina che dice che qualcosa è andato storto
    $html = creaPaginaRisultatiRicercaVuoto();
    
}
print($html);





?>