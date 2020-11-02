<?php

session_start();
include("funzioniQuery.php");
include("funzioniRicercaStudenti.php");
include("funzioniRaccoltaDati.php");
if (isset($_GET["materia"]) && isset($_GET["provincia"]) && $_GET["materia"] != "" && $_GET["provincia"] != "") {
    $materia = $_GET["materia"];
    $provincia = $_GET["provincia"];
    $idMateria = ottieniIdMateria($materia);
    $idProvincia = ottieniIdProvincia($provincia);
    if($idMateria != "" && $idProvincia != ""){
        if (isset($_GET["page"])) {
            $pagina = $_GET["page"];
        } else {
            $pagina = 1;
        }
    
        //variabili
        $dataCorrente = date("Y-m-d h:i:sa");
        //aggiungiamo la ricerca eseguita al nostro database in modo da avere dati anonimi riguardo le ricerche effettuate dai nostri utenti
        aggiungiMateriaCercata($materia,$provincia,$dataCorrente);

        $risultatiPerPagina = 2;
        $risultatoRicercaTotale = queryStudentiRicercaTotale($idMateria, $idProvincia);
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
            $risultatoRicercaPagina = queryStudentiRicercaLimite($idMateria, $idProvincia, $primoRisultatoPagina, $risultatiPerPagina);
            $numeroRisultatiPagina = count($risultatoRicercaPagina);
            for ($i = 0; $i < $numeroRisultatiPagina; $i++) {
                $idStudente = $risultatoRicercaPagina[$i]["ID"];
                $materieStudente = queryMaterieStudente($idStudente);
                $htmlProfili .= creaProfiliStudenti($risultatoRicercaPagina[$i], $materieStudente);
    
            }
        
    
        //creazione footer
            $navigazione = "";
            if ($numeroPagine == 1) {
                $navigazione = "";
            } else {
                $navigazione = creaPaginaFooter($numeroPagine, $pagina, $materia, $provincia);
            }
    
    
            $html = creaPaginaRisultatiRicerca($risultatoRicercaPagina, $numeroPagine, $pagina, $navigazione, $htmlProfili, $materia, $provincia, $numeroRisultatiPagina);
        } else {
    
            $html = creaPaginaRisultatiRicercaVuoto();
        }
    }else{
        $html = creaPaginaRisultatiRicercaVuoto();
    }
    

}else{
    $html = creaPaginaRisultatiRicercaVuoto();  
}
print($html);






?>