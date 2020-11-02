<?php

include("dbconnection.php");
include("funzioniQuery.php");
include("funzioniEmail.php");
session_start();
$contenuto = '';
if (isset($_POST["email"])) {
    $email = $_POST["email"];
    $esistenzaEmail = esistenzaEmail($email);
    if ($esistenzaEmail) {
        $token = creaToken();
        $orarioCorrente = time();
        aggiungiRecordPasswordDimenticata($email,$token,$orarioCorrente);
        $emailInviata = inviaEmailResetPassword($email,$token);
        if($emailInviata){
                $contenuto = '
                <html lang="en">
                <head>
                <meta content="width=device-width, initial-scale=1" name="viewport" />
                <link rel="stylesheet" href="../css/registratiCheck.css" />
                <title>Email inviata</title>
                <meta charset="UTF-8" >
                
                </head>
                
                <body>
                <div class="contenitore">
                <h2>Email inviata</h2>
                <img src="../immagini/mailInviata.svg" />
                <p>Ti abbiamo inviato una mail su <span>' . $email . '</span></p>
                <p>Clicca il link inviato per cambiare la password</p>
                </div>
                </body>
                </html>
            ';
            print($contenuto);
        }else{
            $_SESSION["erroreInvioEmailResetPassword"] = "Email non inviata,perfavore riprova";
            header("location: ../reset/passwordDimenticata.php?err=2");
        }
       
    }else{
        $_SESSION["erroreResetEmail"] = "Non esiste un account con l'email inserita";
        header("location: ../reset/passwordDimenticata.php?err=1");
    }
}




?>