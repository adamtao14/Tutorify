<?php
include("../php/dbConnection.php");
include("../php/funzioniQuery.php");
session_start();

if (isset($_GET["token"]) && isset($_GET["email"])) {
    $output = "";
    $validitaToken = validitaTokenResetPassword($_GET["email"], $_GET["token"]);
    $contenuto = "";
    if ($validitaToken) {
        if (isset($_GET["err"])) {
            $output = "
                <div class='isa_error' id='isa_error'>
                    <i class=' fa fa - times - circle '></i>
                    <strong>Errore</strong><br>
                    <br>
                        {$_SESSION["errorePasswordNonUguali"]}
                    <p id='chiudi'>&#x274C;</p>  
                </div>
                ";
        }
        $contenuto = "
            <!DOCTYPE html>
            <html lang='en'>
            
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='initial-scale=1, viewport-fit=cover'>
                <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                <link rel='shortcut icon' href='../immagini/favicon.ico'/>
                <link rel='shortcut icon' href='http://tutorify.it/immagini/favicon.ico'/>
                <link rel='stylesheet' href='../css/accedi.css'>
                <link rel='stylesheet' href='../css/animate.css'>
                <title>Modifica password</title>
            </head>
            
            <body>
                <div class='container-login animated zoomIn'>
                {$output}
                    <div class='parte-login'>
                        <h2 class='animated zoomIn'>Modifica password</h2>
                        <form action='../php/caricaPasswordModificata.php' method='POST'>
                            <input type='hidden' name='token' value='" . $_GET["token"] . "' class='animated zoomIn' required/>
                            <input type='hidden' name='email' value='" . $_GET["email"] . "' class='animated zoomIn' required/>
                            <input type='password' name='password' placeholder='Nuova password' class='animated zoomIn' required/>
                            <br>
                            <input type='password' name='confPassword' placeholder='Conferma password' class='animated zoomIn' required/>
                            <br>
                            <input type='submit' name='submit' class='animated zoomIn' value='Invia'/>
            
                        </form>
                    </div>
            
                </div>
                <script src='../js/chiudiErrore.js'></script>
            </body>
            
            </html>
            
            
            ";
    } else {
        $contenuto = "
                <html lang='en'>
                    <head>
                    <meta content='width=device-width, initial-scale=1' name='viewport' />
                    <link rel='stylesheet' href='../css/registratiCheck.css' />
                    <title>LINK SCADUTO</title>
                    <meta charset='UTF-8' >
                    
                    </head>
                    
                    <body>
                    <div class='contenitore'>
                    <h2>Il link è scaduto!</h2>
                    <img src='../immagini/cancella.svg' />
                    <p>Perfavore riprova a con un link valido</p>
                    <a href='passwordDimenticata.php'>Riprova</a>
                    </div>
                    </body>
                </html>
            
            ";
    }
    print($contenuto);

}



?>