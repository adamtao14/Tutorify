<?php

include("dbconnection.php");
$GLOBALS['dbConn'] = $db_connection;


function aggiungiMateriaCercata($materia, $provincia, $data){
    $sql = 'INSERT INTO data_materie_ricercate(materia,provincia,data) VALUES(:materia,:provincia,:data)';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':materia', $materia);
    $stmt->bindParam(':provincia', $provincia);
    $stmt->bindParam(':data', $data);
    $stmt->execute();
}


?>