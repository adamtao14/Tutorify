<?php 
include("dbconnection.php");
include("funzioniquery.php");
session_start();
$GLOBALS['dbConn'] = $db_connection;


if(isset($_POST["descrizione_a"])){
$esito_M=modificaMateria($_POST["id_a"],$_POST["descrizione_a"]);
if($esito_M){
	print_r("modificato ");

 }else{
 		print("errore nella modificato, messaggio non modificato")	;
 }

}else{
	if(isset($_POST["nome_indirizzo_a"])){
$esito_I=modificaIndirizzo($_POST["id_a"],$_POST["nome_indirizzo_a"]);
if($esito_I){
	print_r("modificato");

 }else{
 		print("errore nella modificato, messaggio non modificato")	;
 }
}

}
if(isset($_POST["elimina_M_a"])){
	$esito_E=eliminaMateria($_POST["id_a"]);
	if($esito_E){
	print("eliminato");

 }else{
 		print("errore nell'eliminazione")	;
 }
}
if(isset($_POST["elimina_I_a"])){
	$esito_I=eliminaIndirizzo($_POST["id_a"]);
	if($esito_I){
	print("eliminato");

 }else{
 		print("errore nell'eliminazione")	;
 }
}
if(isset($_POST["elimina_C_a"])){
	$esito_C=eliminaContatti($_POST["id_a"]);
	if($esito_C){
	print("eliminato");

 }else{
 		print("errore nell'eliminazione")	;
 }
}


?>