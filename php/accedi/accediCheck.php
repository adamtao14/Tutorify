<?php

session_start();

require("funzioneAccesso.php");

if (isset($_POST["submit"])) {
    
    $email = $_POST["email"];
    $password = $_POST["password"];
    //accesso
    $accesso = accedi($email,$password);
    if($accesso){
        $_SESSION["accessoMessaggioErrore"]="";
        header("location:../../home/dashboard.php");
    }else{
        $_SESSION["accessoMessaggioErrore"]="Email/password errati";
        header("location:../../login/accedi.php?err=1&email=".$email."");
    }
}



?>