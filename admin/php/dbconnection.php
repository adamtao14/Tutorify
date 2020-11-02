<?php

// questo file serve per la connessione al database

$hostname = "89.46.111.198";
$user = "Sql1438083";
$pass = "12704d8247";
$dbname = "Sql1438083_1";

try {
	$db_connection = new PDO("mysql:host=$hostname;dbname=$dbname", $user, $pass);
} catch (PDOException $e) {
	$db_connection = null;
	die("Errore in connessione : " . $e->getMessage());
};


?>