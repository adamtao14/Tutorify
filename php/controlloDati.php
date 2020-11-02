<?php

// questo file contiene le varie funzioni che servono alla pagina registrati.php per fare i vari controlli sugli input ottenuti

require("dbconnection.php");

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function controlloEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}
function controlloPassword($password)
{
    $maiuscolo = preg_match('@[A-Z]@', $password);
    $minuscole = preg_match('@[a-z]@', $password);
    $numeri = preg_match('@[0-9]@', $password);
    if (!$maiuscolo || !$minuscole || !$numeri || strlen($password) < 8) {
        return false;

    } else {
        return true;
    }
}
function passwordUguali($password, $confPasssword)
{
    if ($password == $confPasssword) {
        return true;
    } else {
        return false;
    }
}

?>