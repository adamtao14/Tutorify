<?php
session_start();
include("../../php/sessionExpiration.php");
include("../../php/funzioniQuery.php");
include("../../php/paginaProfilo.php");

//controllo stato della sessione
if (isset($_SESSION["id"])) {
    if (isLoginSessionExpired()) {
        header("Location:../../logout/logout.php?sessione_scaduta=1");
    } else {
        if ($_SESSION["profilo_completato"] == 0) {
            header("Location:../../completamento/completaRegistrazione.php");
        }
    }

    //ottengo le informazioni dell'utente 
    $risultato = ottieniDatiStudente($_SESSION["id"]);
    $scuola = ottieniStudenteScuola($_SESSION["id"]);
    $materie = ottieniMaterieStudenti($_SESSION["id"]);
    $scuola_scelta = $scuola[0];
    //riempo le variabili con i risultati otttenuti
    $dati = $risultato[0];
    $nome = $dati["nome"];
    $cognome = $dati["cognome"];
    $comune = $dati["nome_comune"];
    $num_classe = $dati["num_classe"];
    $nome_indirizzo = $dati["nome_indirizzo"];
    $descrizione = $dati["descrizione"];
    $data_nascita = $dati["data_nascita"];
    $banner_profilo = $dati["banner_profilo"];
    $immagine_profilo = $dati["immagine_profilo"];
    $scuola_studente = $scuola_scelta["nome"];
    $eta = calcolaEta($data_nascita);
    if ($immagine_profilo == null) {
        $immagine_profilo = 'immagini_default/default_profilo.jpg';
    }else{
        $immagine_profilo = "../../uploads/" . $dati["immagine_profilo"];
    }
    if ($banner_profilo == null) {
        $banner_profilo = 'immagini_default/default_banner.jpg';
    }else{
        $banner_profilo = "../../uploads/" . $dati["banner_profilo"];
    }
    if ($descrizione == "") {
        $descrizione = "Non hai fornito una descrizione";
    }
    if ($materie == "") {
        $materie = "Nessuna materia selezionata";
    }
    $recensioniStudente = ottieniRecensioni($_SESSION["id"]);
    $numeroRecensioni = count($recensioniStudente);
    $recensioniHtml = creaRecensioniProfilo($recensioniStudente);

    //registrazione dei vari dati in sessione

    $_SESSION["nome"] = $nome;
    $_SESSION["cognome"] = $cognome;
    $_SESSION["comune"] = $comune;
    $_SESSION["num_classe"] = $num_classe;
    $_SESSION["nome_indirizzo"] = $nome_indirizzo;
    $_SESSION["descrizione"] = $descrizione;
    $_SESSION["eta"] = $eta;
    $_SESSION["scuola"] = $scuola_studente;
    $_SESSION["immagine_profilo"] = $immagine_profilo;
    $_SESSION["banner_profilo"] = $banner_profilo;
    $_SESSION["data_nascita"] = $data_nascita;
    $_SESSION["materie"] = $materie;
    
    //creazione pagina profilo dinamica
    $html = creaPaginaProfilo($recensioniHtml, $numeroRecensioni);
    print($html);

} else {
    header("Location:../../login/accedi.php");
}


?>
