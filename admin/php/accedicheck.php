<?php
session_start();
require("dbconnection.php");
require("funzioniquery.php");

if(isset($_POST["invia"])){
  $username_a=$_POST["username_a"];
  $password_a=$_POST["password_a"];
  $accesso_a= accedi($username_a,$password_a);
  if($accesso_a){
      $_SESSION["accessoMessaggioErrore"]="";
      $_SESSION["username_a"]=$_POST["username_a"];
      header("location:../home/index.php");
  }else{
    $_SESSION["accessoMessaggioErrore"]="Username/password errati";
    header("location:../index.php?err=1");


  }

}







 ?>
