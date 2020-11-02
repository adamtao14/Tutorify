<?php

require('../php/dbconnection.php');
require('../php/funzioniQuery.php');

//controllo se il token e l'email si trovano nell'url => conferma che il link è valido
if (isset($_GET["token"]) && isset($_GET["email"])) {

    $tokenDaVerificare = $_GET["token"];
    $emailDaVerificare = $_GET["email"];

    //confermo che il token appartiene all'email
    $conferma = confermaUtente($tokenDaVerificare, $emailDaVerificare);
    if ($conferma) {
        $verificaUtente = verificaUtente($emailDaVerificare); //cambio il valore del campo verificato da 0 a 1 sul database
        if ($verificaUtente) {
            //pagina di conferma della verificazione
            $contenuto = '
            <html lang="en">
            <head>
              <meta content="width=device-width, initial-scale=1" name="viewport" />
              <link rel="stylesheet" href="../css/registratiCheck.css" />
              <title>VERIFICA EMAIL</title>
              <meta charset="UTF-8" >
            
            </head>
            
            <body>
             <div class="contenitore">
             <h2>Verificato con successo</h2>
               <img src="../immagini/conferma.svg" />
               <p>Ottimo ora puoi accedere al tuo account</p>
               <a class="link" href="../login/accedi.php">Accedi</a>
             </div>
            </body>
            </html>';
            
        }else{
            //pagina di errore
            $contenuto = '
            <html lang="en">
            <head>
              <meta content="width=device-width, initial-scale=1" name="viewport" />
              <link rel="stylesheet" href="../css/registratiCheck.css" />
              <title>VERIFICA EMAIL</title>
              <meta charset="UTF-8" >
            
            </head>
            
            <body>
             <div class="contenitore">
             <h2>Ops qualcosa non ha funzionato!</h2>
               <img src="../immagini/cancella.svg" />
               <p>Non siamo riusciti a verificare la tua email</p>
               <a class="link" href="../signup/registrati.php">Riprova</a>
             </div>
            </body>
            </html>';
            //cancello l'utente dal database siccome la registrazione non è andata a buon fine in modo da darli un altra possibilità di provare
            cancellaUtenteInFaseDiRegistrazione($emailDaVerificare);
        }
        
        
    }else{
        $contenuto = '
            <html lang="en">
            <head>
              <meta content="width=device-width, initial-scale=1" name="viewport" />
              <link rel="stylesheet" href="../css/registratiCheck.css" />
              <title>VERIFICA EMAIL</title>
              <meta charset="UTF-8" >
            
            </head>
            
            <body>
             <div class="contenitore">
             <h2>Ops qualcosa non ha funzionato!</h2>
               <img src="../immagini/undraw_cancel_u1it.svg" />
               <p>Non siamo riusciti a verificare la tua email</p>
               <a href="../signup/registrati.php">Riprova</a>
             </div>
            </body>
            </html>';
            //cancello l'utente dal database siccome la registrazione non è andata a buon fine in modo da darli un altra possibilità di provare
            cancellaUtenteInFaseDiRegistrazione($emailDaVerificare);
    }
    print($contenuto);

}







?>