<?php
session_start();
include("php/dbconnection.php");
$output="";

if(isset($_GET["err"])){
print_r($_SESSION["accessoMessaggioErrore"]);

}
if (isset($_GET["sessione_scaduta"])) {
            $output = "
        <div class='isa_warning' id='isa_error'>
            <i class=' fa fa - times - circle '></i>
            <strong>Errore</strong><br>
            <br>
                Sessione scaduta,accedi di nuovo!
             <p id='chiudi'>&#x274C;</p>   
        </div>
        ";
        }
print($output);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="../css/accedi.css">
    <link rel="stylesheet" href="../css/animate.css">
    <title>Pagina Admin</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@700&display=swap" rel="stylesheet">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    </head>
      <body>
      <header>
        <div class="container center-div shadow">
          <div class="heading text-center text-uppercase text-white mb-4">ADMIN TUTORIFY PAGE</div>
          <div class="container row d-flex flex-row justify-content-center mb-5 ">
            <div class="admin-form shadow p-2">
              
              <form method='POST' action='php/accedicheck.php'>
                <div class="form-group">
                  <label>USERNAME</label>

                  <input type='text' name='username_a' class="form-control" autocomplete="off"></input>
                </div>
                  <div class="form-group">
                    <label>PASSWORD</label>
                  <input type='password' name='password_a' class="form-control" autocomplete="off"></input>
                </div>
                  <input type='submit' name='invia' class="btn btn-success" placeholder='invia'>
                  </form>
            </div>

            </div>

          </header>
           <script src="../js/chiudiErrore.js"></script>
      </body>
</html>
