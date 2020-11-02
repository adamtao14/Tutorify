
<?php

session_start();
include '../../php/funzioniquery.php';
include("../../php/sessionExpiration.php");
if (isset($_SESSION["id_a"])){
  if (isLoginSessionExpired()) {
  header("Location:../logout/logout.php?sessione_scaduta=1");
}
}
if (!isset($_SESSION["username_a"])){
  header("Location:../logout/logout.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin_Tutorify</title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/simple-sidebar.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
      <div class="sidebar-heading"><?php Print_r($_SESSION["username_a"])  ?></div>
      <div class="list-group list-group-flush">
        <a href="utenti.php" class="list-group-item list-group-item-action bg-dark" style="color: white;">Utenti</a>
        <a href="materie.php" class="list-group-item list-group-item-action bg-light">Materie</a>
        <a href="indirizzi.php" class="list-group-item list-group-item-action bg-light">Indirizzi</a>
                <a href="contattaci.php" class="list-group-item list-group-item-action bg-light">Contatti</a>
        <a href="../logout/logout.php" class="list-group-item list-group-item-action bg-light">Logout</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

      <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button style="background-color: #7B68EE" class="btn btn-primary" id="menu-toggle">Toggle Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
            <li class="nav-item active">
              <a class="nav-link" href="../../" target="_blank">Home <span class="sr-only">(current)</span></a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Dropdown
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Action</a>
                <a class="dropdown-item" href="#">Another action</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="../logout/logout.php">Logout</a>
              </div>
            </li>
          </ul>
        </div>
      </nav>

      <div class="container-fluid">
        <h1 class="mt-4" style=" color:#7B68EE;text-shadow: -1px 0 black, 0 1px black, 1px 0 black, 0 -1px black">Tutorify Admin </h1>
                <h2 class="mt-4">Utenti</h2>
        <p>Il numero totale di utenti registrati è : <?php   print_r(numUtenti());?> <img src="../images/group.png" style="width: 2%;margin-left: 2px;margin-top: -10px;"></p>
        <p></p>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>

</body>

</html>
