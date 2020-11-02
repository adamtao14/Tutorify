<?php

session_start();
include("funzioniQuery.php");

    $passwordInserita = $_POST["password"];
    $passwordUtenteCriptata = ottieniPasswordCriptataUtente($_SESSION["id"]);
    $esito = "";
    if(password_verify($passwordInserita,$passwordUtenteCriptata)){
        $esito = "1";
    }else{
        $esito = "0";
    }
    print($esito);





?>