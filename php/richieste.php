<?php

session_start();
include("funzioniQuery.php");
include("funzioniRichieste.php");
$idProvincia = cercaIdProvinciaConComune($_SESSION["comune"]);
if (isset($_GET)) {
    if (isset($_GET["page"])) {
        $pagina = $_GET["page"];
    } else {
        $pagina = 1;
    }
    if(isset($_GET["materia"])){
        $materiaDaCercare = $_GET["materia"];
        $idMateria = ottieniIdMateria($materiaDaCercare);
    }

    //variabili
    $provincia = ottieniProvincia($idProvincia);
    $listaMaterie = ottieniMaterie();
    $risultatiPerPagina = 2;
    if(isset($_GET["materia"])){
        $risultatoRicercaTotale = queryRichiesteRicercaTotaleConMateria($idProvincia, $idMateria);   
    }else{
        $risultatoRicercaTotale = queryRichiesteRicercaTotale($idProvincia);
    }
    if (count($risultatoRicercaTotale) > 0) {
        $numeroPagine = ceil(count($risultatoRicercaTotale) / $risultatiPerPagina);
        if ($pagina > $numeroPagine) {
            $pagina = $numeroPagine;
        }
        if ($pagina < 1) {
            $pagina = 1;
        }
    //totale risultati ottenuti
        $primoRisultatoPagina = ($pagina - 1) * $risultatiPerPagina;

    //query per ogni pagina
        $htmlProfili = "";
        if(isset($_GET["materia"])){
            $risultatoRicercaPagina = queryRichiesteRicercaLimiteConMateria($idProvincia, $idMateria, $primoRisultatoPagina, $risultatiPerPagina);
        }else{
            $risultatoRicercaPagina = queryRichiesteRicercaLimite($idProvincia, $primoRisultatoPagina, $risultatiPerPagina);
        }
        
        for ($i = 0; $i < count($risultatoRicercaPagina); $i++) {
            $idStudente = $risultatoRicercaPagina[$i]["fk_id_studente"];
            $htmlProfili .= creaProfiliStudenti($risultatoRicercaPagina[$i]);

        }
    

    //creazione footer
        $navigazione = "";
        if ($numeroPagine == 1) {
            $navigazione = "";
        } else {
            if(isset($_GET["materia"])){
                $navigazione = creaPaginaFooterMateria($numeroPagine, $pagina, $_GET["materia"]);
            }else{
                $navigazione = creaPaginaFooter($numeroPagine, $pagina);
            }
            
        }


        $html = creaPaginaRisultatiRicerca($risultatoRicercaPagina, $numeroPagine, $pagina, $navigazione, $htmlProfili, $provincia, $listaMaterie);
    } else {
        $materiaScelta = "";
        if(isset($_GET["materia"])){
            $materiaScelta = "per ".$_GET["materia"];
        }
        $html = creaPaginaRisultatiRicercaVuoto($provincia, $materiaScelta);
    }

    print($html);


}






?>