<?php
session_start();
include("../php/sessionExpiration.php");
include("../php/funzioniQuery.php");

//Controllo stato della sessione
if (isset($_SESSION["id"])) {
    if (isLoginSessionExpired()) {
        header("Location:../logout/logout.php?sessione_scaduta=1");
    }else{
        if($_SESSION["profilo_completato"] == 1){
            header("Location:../home/dashboard.php");
        }
    }
}

//dichiarazione delle variabili e ottenimento dei dati da mettere nelle select
$scuolaScelta="";
$classeScelta="";
$indirizzoScelto="";
$listaClassi = ottieniClassi($classeScelta);
$listaIndirizzi = ottieniIndirizzi($indirizzoScelto);
$listaMaterie = ottieniMaterie();

//creazione dinamica della pagina
$output="
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Completa registrazione</title>
    <link rel='shortcut icon' href='../immagini/favicon.ico'/>
    <link rel='shortcut icon' href='http://tutorify.it/immagini/favicon.ico'/>
    <link rel='stylesheet' href='../css/completaRegistrazione.css' />
    <script src='https://code.jquery.com/jquery-3.4.1.min.js' integrity='sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=' crossorigin='anonymous'></script>
    <link href='https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js'></script>
</head>
<body>
    <form id='regForm' action='../php/caricaDatiFinali.php' method='POST'>
        <h1>Completa la registrazione</h1>
        <div class='tab'>
        <b>Scuola</b> 
            <p>
                <input type='text' name='scuolaScelta' id='scuola' />
                <div id='listaScuole' class='animated zoomIn'>

                </div>
            </p>
            <b>Classe</b>
            <p>
                <select class='js-example-basic-single' name='classe' oninput='this.className = ''' style='width:100%' required>
                    {$listaClassi}
                </select>
            </p>
            
        </div>
        <div class='tab'>
            <b>Indirizzo scolastico</b>
            <p>
                <select class='js-example-basic-single' name='indirizzo' oninput='this.className = ''' style='width:100%' required>
                    {$listaIndirizzi}
                </select>
            </p>
        </div>
        <div class='tab'>
            <b>Materie in cui sei bravo</b>
            <p>
                <select class='js-example-basic-single' id='listaMaterie' name='materie[]' multiple='multiple' oninput='this.className = ''' style='width:100%' required>
                    {$listaMaterie}
                </select>
            </p>
        </div>
        <div class='tab'>
            <b>Dicci un po di te</b><br>
            <textarea name='descrizione' maxlength='255'>
            </textarea>
        </div>
        <div style='overflow:auto;'>
            <div style='float:right;'>
            <button type='button' id='prevBtn' onclick='nextPrev(-1)'>Indietro</button>
            <button type='button' id='nextBtn' onclick='nextPrev(1)'>Successivo</button>
            </div>
        </div>
        <div style='text-align:center;margin-top:40px;'>
            <span class='step'></span>
            <span class='step'></span>
            <span class='step'></span>
            <span class='step'></span>
        </div>
    </form>
    
</body>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
        $('#listaMaterie').select2({
            closeOnSelect: false
          });
    }); 
</script>
<script src='../js/completaRegistrazione.js'></script>
<script src='../js/ricercaScuole.js'></script>
</html>


";
print($output);
?>