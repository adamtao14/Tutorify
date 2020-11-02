<?php

include("dbconnection.php");
$GLOBALS['dbConn'] = $db_connection;

function ottieniNumeroUtentiSito(){
    $sql = "SELECT COUNT(ID) AS utenti FROM studenti";
    $stmt = $GLOBALS['dbConn']->query($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function ottieniNumeroRecensioniSito(){
    $sql = "SELECT COUNT(ID) AS recensioni FROM recensioni";
    $stmt = $GLOBALS['dbConn']->query($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function ottieniNumeroMaterieSito(){
    $sql = "SELECT COUNT(ID) AS materie FROM materie";
    $stmt = $GLOBALS['dbConn']->query($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function ottieniNumeroProvinceSito(){
    $sql = "SELECT COUNT(ID) AS prov FROM province";
    $stmt = $GLOBALS['dbConn']->query($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}




?>