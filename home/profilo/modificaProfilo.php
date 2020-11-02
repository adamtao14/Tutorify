<?php

session_start();
include("../../php/sessionExpiration.php");
include("../../php/funzioniQuery.php");
include("../../php/paginaProfilo.php");

//controllo stato della sessione
if (isset($_SESSION["id"])) {
    if (isLoginSessionExpired()) {
        header("Location:../../logout/logout.php?sessione_scaduta=1");
    } else {
        if ($_SESSION["profilo_completato"] == 0) {
            header("Location:../../completamento/completaRegistrazione.php");
        }
    }
    //creazione della pagina di modifica profilo dinamicamente
    $html = creaPaginaModificaProfilo();
    print($html);
}


?>