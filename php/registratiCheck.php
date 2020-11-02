<?php

// questo file permette di registrare un nuovo utente al sito facendo gli opportuni controlli
session_start();

require("dbconnection.php");
require("controlloDati.php");
require_once("funzioniEmail.php");
require("funzioniQuery.php");
$GLOBALS['dbConn'] = $db_connection;
if (isset($_POST["submit"])) {

    $errori = "";
    $nome = $_POST["nome"];
    $cognome = $_POST["cognome"];
    $email = $_POST["email"];
    $dataNascita = $_POST["dataNascita"];
    $residenza = $_POST["residenza"];
    $telefono = $_POST["telefono"];
    $password = $_POST["password"];
    $confPassword = $_POST["confPassword"];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $nome = test_input($nome);
    $cognome = test_input($cognome);

    $nome = ucfirst($nome);
    $cognome = ucfirst($cognome);
    if($telefono != ""){
        if(strlen($telefono) > 10){
            $errori .= "-Numero di telefono non valido<br>";
        }
        if(esistenzaTelefono($telefono)){
            $errori .= "-Numero di telefono già in uso<br>";
        }
    }
    
    
    $emailvalidity = controlloEmail($email);
    if (!$emailvalidity) {
        $errori .= "-Email non valida<br>";
    }
    $controlloValiditaPassword = controlloPassword($password);
    if (!$controlloValiditaPassword) {
        $errori .= "-La password deve avere lettere maiuscole-minuscole/numeri/8 caratteri<br>";
    }
    $passwordUguali = passwordUguali($password, $confPassword);
    if (!$passwordUguali) {
        $errori .= "-Le password non sono uguali<br>";
    }
    $emailInUso = esistenzaEmail($email);
    if ($emailInUso) {
        $errori .= "-Email già in uso<br>";
    }
    if (!$errori == "") {
        $_SESSION["registrazioneMesaggioErrori"] = $errori;
        header("location:../signup/registrati.php?err=1");
    } else {
        $passwordCriptata = password_hash($password, PASSWORD_DEFAULT);
        $token = creaToken();
        $verificato = 0;
        $profilo_completato = 0;
        $ruolo = 2;
        $id_residenza = cercaIdResidenza($residenza);
        $risultatoInsert = caricaDati($nome,$cognome,$email,$passwordCriptata,$dataNascita,$id_residenza,$ruolo,$verificato,$profilo_completato,$token);
        if($risultatoInsert){
            $_SESSION["registrazioneMesaggioErrori"] = "";
            $invioEmail=inviaEmailVerifica($email, $token, $nome);
            if($invioEmail){
                $contenuto ='
                        <html lang="en">
                        <head>
                        <meta content="width=device-width, initial-scale=1" name="viewport" />
                        <link rel="stylesheet" href="../css/registratiCheck.css" />
                        <title>VERIFICA EMAIL</title>
                        <meta charset="UTF-8" >
                        
                        </head>
                        
                        <body>
                        <div class="contenitore">
                        <h2>Ci siamo quasi!</h2>
                        <img src="../immagini/mailInviata.svg" />
                        <p>Ti abbiamo inviato una mail su <span>'.$email.'</span></p>
                        <p>(La mail potrebbe trovarsi nella cartella spam)</p>
                        </div>
                        </body>
                        </html>
                    ';
            print($contenuto);
            }else{
                cancellaUtenteInFaseDiRegistrazione($email);
                $_SESSION["registrazioneMesaggioErrori"] = "Errore nella spedizione della mail,perfavore riprova tra poco";
            header("location:../signup/registrati.php?err=1");
            
            }
            

        }else{
            $_SESSION["registrazioneMesaggioErrori"] = "Errore nella registrazione,perfavore riprova tra poco";
            header("location:../signup/registrati.php?err=1");
        }
    }

}else{
    if(isset($_SESSION["id"])){
        header("location:../home/dashboard.php");
    }else{
        header("location:../index.html");
    }
}

?>