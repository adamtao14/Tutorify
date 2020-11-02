<?php
include("dbconnection.php");
$GLOBALS['dbConn'] = $db_connection;



function accedi($username,$password){
  $checkpww="password errata";
  $esitoAccesso = false;
  $sql = "SELECT ID,username,password  FROM admin WHERE username=:username";
  $stmt = $GLOBALS['dbConn']->prepare($sql);
  $stmt->bindParam(':username', $username);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $row=$rows[0];
  $password_criptata = $row["password"];
  print_r($rows);
  $password_criptata = $row["password"];
  if (password_verify($password, $password_criptata)) {
  $esitoAccesso = true;
  $_SESSION["username_a"] = $row["username"];
  $_SESSION["password_a"] = $row["password"];
  $_SESSION["id_a"]=$row["ID"];
  $_SESSION["ultimo_accesso_a"] = time();
}else {

}
    return $esitoAccesso;
}

function numUtenti()
{
  $sql="SELECT COUNT(*) FROM studenti";
  $stmt = $GLOBALS['dbConn']->prepare($sql);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $row=$rows[0];
  $row["COUNT(*)"];
  return $row["COUNT(*)"];

}








function modificaMateria($ID,$descrizione){
    $sql = "UPDATE materie SET  descrizione=:descrizione WHERE ID=:id ";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':descrizione', $descrizione);
    $stmt->bindParam(':id', $ID);
       if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }


}
function eliminaMateria($ID){
    $sql = "DELETE FROM  materie WHERE  ID=:id ";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':id', $ID);
       if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

}
function modificaIndirizzo($ID,$indirizzo){
    $sql = "UPDATE indirizzi_scolastici SET  nome_indirizzo=:indirizzo WHERE ID=:id ";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':indirizzo', $indirizzo);
    $stmt->bindParam(':id', $ID);
       if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }


}
function eliminaIndirizzo($ID){
    $sql = "DELETE FROM  indirizzi_scolastici WHERE  ID=:id ";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':id', $ID);
       if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

}
function mostraContatti(){
  $sql="SELECT * FROM contatti";
  $stmt = $GLOBALS['dbConn']->prepare($sql);
  $stmt->execute();
  $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
  return $rows;


}
function eliminaContatti($ID){
    $sql = "DELETE FROM  contatti WHERE  ID=:id ";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':id', $ID);
       if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }

}


 ?>
