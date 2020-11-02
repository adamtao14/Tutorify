<?php
include("../dbconnection.php");
$GLOBALS['dbConn'] = $db_connection;

function accedi($email, $password)
{
    $esitoAccesso = false;
    $sql = "SELECT studenti.ID,nome,email,studenti.ruolo,ruoli.ruolo,comuni.nome_comune,studenti.residenza,studenti.telefono,password,profilo_completato FROM studenti,ruoli,comuni WHERE email=:email AND studenti.ruolo=ruoli.ID  AND comuni.ID = studenti.residenza LIMIT 1";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (sizeof($rows) > 0) {
        $row = $rows[0];
        $password_criptata = $row["password"];
        if (password_verify($password, $password_criptata)) {
            $esitoAccesso = true;
            $_SESSION["email"] = $row["email"];
            $_SESSION["id"] = $row["ID"];
            $_SESSION["nome"] = $row["nome"];
            $_SESSION["ruolo"] = $row["ruolo"];
            $_SESSION["profilo_completato"] = $row["profilo_completato"];
            $_SESSION["ultimo_accesso"] = time();
            $_SESSION["comune"] = $row["nome_comune"];
            $_SESSION["telefono"] = $row["telefono"];
        }

    }
    return $esitoAccesso;
}

?>