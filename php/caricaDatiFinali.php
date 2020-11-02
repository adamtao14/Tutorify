<?php
include("dbconnection.php");
include("funzioniQuery.php");
session_start();

$GLOBALS['dbConn'] = $db_connection;
$scuolaScelta = $_POST["scuolaScelta"];
$classeScelta = $_POST["classe"];
$indirizzoScelto = $_POST["indirizzo"];
$descrizione = $_POST["descrizione"];
if(isset($_POST["materie"])){
    $numeroMaterieScelte = count($_POST["materie"]);
    for ($i = 0; $i < $numeroMaterieScelte; $i++) {
        $idMateriaScelta = cercaIdMateriaScelta($_POST["materie"][$i]);
        aggiungiMateriaStudente($idMateriaScelta,$_SESSION["id"]);
    
    }
}

$idStudente = $_SESSION["id"];

$idScuolaScelta = cercaIdScuola($scuolaScelta);
if($idScuolaScelta == null){
    caricaScuola($scuolaScelta);
    $idScuolaScelta = cercaIdScuola($scuolaScelta);
}
$idClasseScelta = cercaIdClasse($classeScelta);
$idIndirizzoScelto = cercaIdIndirizzoScelto($indirizzoScelto);

$updateScuola = updateScuola($idScuolaScelta,$idStudente);
$updateClasse = updateClasse($idClasseScelta,$idStudente);
$updateIndirizzo = updateIndirizzo($idIndirizzoScelto,$idStudente);
$updateDescrizione = updateDescrizione($descrizione,$idStudente);



if ($updateClasse && $updateIndirizzo && $updateScuola && $updateDescrizione) {
    $completato = profiloCompletato($_SESSION["id"]);
    if ($completato) {
        $_SESSION["profilo_completato"]=1;
        $contenuto = '
        <html lang="en">
        <head>
          <meta content="width=device-width, initial-scale=1" name="viewport" />
          <link rel="stylesheet" href="../css/registratiCheck.css" />
          <title>Profilo completato</title>
          <meta charset="UTF-8" >
        
        </head>
        
        <body>
         <div class="contenitore">
         <h2>Profilo completato con successo</h2>
           <img src="../immagini/conferma.svg" />
           <p>Ottimo ora puoi usare Tutorify</p>
           <a class="link" href="../home/dashboard.php">Dashboard</a>
         </div>
        </body>
        </html>';
    }

    print($contenuto);



}





?>