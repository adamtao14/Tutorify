<?php
include("funzioniQuery.php");
include("controlloDati.php");
session_start();
if(isset($_POST)){
    $password = $_POST["password"];
    $confPassword = $_POST["confPassword"];
    $email = $_POST["email"];
    $token = $_POST["token"];
    $uguali = passwordUguali($password,$confPassword);
    $controlloPassword = controlloPassword($password);
    if($uguali && $controlloPassword){
        $passwordCriptata = password_hash($password, PASSWORD_DEFAULT);
        $esito = modificaPassword($passwordCriptata,$email);
        if($esito){
            eliminaRecordPasswordDimenticata($email,$token);
            $contenuto = '
            <html lang="en">
            <head>
              <meta content="width=device-width, initial-scale=1" name="viewport" />
              <link rel="stylesheet" href="../css/registratiCheck.css" />
              <title>PASSWORD MODIFICATA</title>
              <meta charset="UTF-8" >
            
            </head>
            
            <body>
             <div class="contenitore">
             <h2>Password modificata</h2>
               <img src="../immagini/conferma.svg" />
               <p>La password è stata modificata con successo</p>
               <a href="../login/accedi.php">Accedi</a>
             </div>
            </body>
            </html>';
            print($contenuto);
        }
    }else{
        $_SESSION["errorePasswordNonUguali"]="Le password non sono uguali o non valide";
        header("location:../reset/modificaPassword.php?token=".$token."&email=".$email."&err=1");
    }
}





?>