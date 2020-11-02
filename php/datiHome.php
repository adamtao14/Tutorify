<?php

include("funzioniDatiHome.php");

$numeroStudenti = ottieniNumeroUtentiSito();
$numeroMaterie = ottieniNumeroMaterieSito();
$numeroRecensioni = ottieniNumeroRecensioniSito();
$numeroProvince = ottieniNumeroProvinceSito();
$numeroStudenti = $numeroStudenti[0]["utenti"];
$numeroMaterie = $numeroMaterie[0]["materie"];
$numeroRecensioni = $numeroRecensioni[0]["recensioni"];
$numeroProvince = $numeroProvince[0]["prov"];
print($numeroStudenti."-".$numeroRecensioni."-".$numeroMaterie."-".$numeroProvince);


?>