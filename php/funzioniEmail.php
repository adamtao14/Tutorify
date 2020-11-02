<?php


require_once '../dati/costanti.php';




function inviaEmailVerifica($userEmail, $token, $nome)
{
    $to = $userEmail;
    $subject = "Tutorify conferma la tua email";

    $message = "
    <html lang='en'>
    <head>
      <meta charset='utf-8'>
      <style>
      @media screen and(max-width:400px;){
        .wrapper{
          margin-left:-100px;
          width:200px;
        }
      }
      
      </style>
      <title>VERIFICA EMAIL</title>
      <meta charset='UTF-8' >
    
    </head>
    
    <body>
     <div>
        <h2 style='font-size:28px;'>Ciao " . $nome . "</h2><br>
        <p style='font-size:19px;'>Grazie per esserti iscritto a Tutorify,clicca il link sotto per verificare il tuo account</p><br>
        <a href='https://www.tutorify.it/completamento/confermaEmail.php?token=".$token ."&email=".$userEmail."' >https://tutorify.it/completamento/confermaEmail.php?token=".$token ."&email=".$userEmail."</a>
     </div>
    </body>
    </html>";

    $header = "From:".EMAIL."\r\n";
    $header .= "Cc:".$userEmail."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";
    $retval = mail ($to,$subject,$message,$header);
    return $retval;
}
function inviaEmailResetPassword($userEmail, $token)
{
    $to = $userEmail;
    $subject = "Tutorify recupero password";

    $message = "
    <html lang='en'>
    <head>
      <meta charset='utf-8'>
      <title>Recupera password</title>
      <meta charset='UTF-8' >
    
    </head>
    
    <body>
     <div>
        <h2 style='font-size:28px;'>Ciao</h2><br>
        <p style='font-size:19px;'>Hai richiesto la modifica della tua password</p><br>
        <p style='font-size:19px;'>Clicca  il link per modificare la password</p><br>
        <a href='https://www.tutorify.it/reset/modificaPassword.php?token=".$token ."&email=".$userEmail."'>https://tutorify.it/reset/modificaPassword.php?token=".$token ."</a>
     </div>
    </body>
    </html>";

    $header = "From:".EMAIL."\r\n";
    $header .= "MIME-Version: 1.0\r\n";
    $header .= "Content-type: text/html\r\n";
    $retval = mail ($to,$subject,$message,$header);
    return $retval;
}



?>