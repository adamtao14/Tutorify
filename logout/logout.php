<?php
session_start();
session_unset();
session_destroy();
if(isset($_GET["sessione_scaduta"])){
    header("location: ../login/accedi.php?sessione_scaduta=1");
}else{
    header("location: ../login/accedi.php");
}


?>