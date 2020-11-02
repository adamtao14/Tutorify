<?php
include("dbconnection.php");
$GLOBALS['dbConn'] = $db_connection;

function queryRichiesteRicercaTotaleConMateria($idResidenza, $idMateria)
{
    $sql = "SELECT studenti.nome,studenti.cognome,materie.descrizione as descrizioneMateria,richieste.data,richieste.descrizione as descrizioneRichiesta,comuni.nome_comune
            FROM richieste,studenti,materie,comuni
            WHERE fk_id_provincia =:idResidenza
            AND studenti.ID = fk_id_studente
            AND comuni.ID = studenti.residenza
            AND materie.ID = :idMateria
            AND fk_id_materia = :idMateria
            AND fk_id_studente != :idStudente;
        ";

    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idResidenza', $idResidenza);
    $stmt->bindParam(':idMateria', $idMateria);
    $stmt->bindParam(':idStudente', $_SESSION["id"]);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function queryRichiesteRicercaTotale($idResidenza)
{
    $sql = "SELECT studenti.nome,studenti.cognome,materie.descrizione as descrizioneMateria,richieste.data,richieste.descrizione as descrizioneRichiesta,comuni.nome_comune
            FROM richieste,studenti,materie,comuni
            WHERE fk_id_provincia =:idResidenza
            AND studenti.ID = fk_id_studente
            AND comuni.ID = studenti.residenza
            AND materie.ID = fk_id_materia
            AND fk_id_studente != :idStudente;
        ";

    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idResidenza', $idResidenza);
    $stmt->bindParam(':idStudente', $_SESSION["id"]);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function queryRichiesteRicercaLimite($idResidenza, $primoRisultatoPagina, $risultatiPerPagina)
{
    $sql = "SELECT richieste.fk_id_studente,studenti.nome,studenti.cognome,studenti.immagine_profilo,materie.descrizione as descrizioneMateria,richieste.data,richieste.descrizione as descrizioneRichiesta,comuni.nome_comune
            FROM richieste,studenti,materie,comuni
            WHERE fk_id_provincia =:idResidenza
            AND studenti.ID = fk_id_studente
            AND materie.ID = fk_id_materia
            AND comuni.ID = studenti.residenza
            AND fk_id_studente != :idStudente
            LIMIT " . $primoRisultatoPagina . "," . $risultatiPerPagina . "";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idResidenza', $idResidenza);
    $stmt->bindParam(':idStudente', $_SESSION["id"]);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function queryRichiesteRicercaLimiteConMateria($idResidenza, $idMateria, $primoRisultatoPagina, $risultatiPerPagina)
{
    $sql = "SELECT richieste.fk_id_studente,studenti.nome,studenti.cognome,studenti.immagine_profilo,materie.descrizione as descrizioneMateria,richieste.data,richieste.descrizione as descrizioneRichiesta,comuni.nome_comune
            FROM richieste,studenti,materie,comuni
            WHERE fk_id_provincia =:idResidenza
            AND studenti.ID = fk_id_studente
            AND comuni.ID = studenti.residenza
            AND materie.ID = :idMateria
            AND fk_id_materia = :idMateria
            AND fk_id_studente != :idStudente
            LIMIT " . $primoRisultatoPagina . "," . $risultatiPerPagina . "";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idResidenza', $idResidenza);
    $stmt->bindParam(':idStudente', $_SESSION["id"]);
    $stmt->bindParam(':idMateria', $idMateria);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function creaPaginaFooter($numeroPagine, $paginaCorrente)
{
    $range = 1;
    $output = "<div class='lista-pagine'>";


    if ($paginaCorrente > 1) {
        $output .= " <a class='freccie-speciali' href='{$_SERVER['PHP_SELF']}?page=1'><<</a> ";
        $paginaPrecedente = $paginaCorrente - 1;
        $output .= " <a class='freccie-speciali' href='{$_SERVER['PHP_SELF']}?page=" . $paginaPrecedente . "'><</a> ";
    }

    for ($x = ($paginaCorrente - $range); $x < (($paginaCorrente + $range) + 1); $x++) {
        if (($x > 0) && ($x <= $numeroPagine)) {
            if ($x == $paginaCorrente) {
                $output .= " <b>$x</b> ";
            } else {
                $output .= " <a href='{$_SERVER['PHP_SELF']}?page=" . $x . "'>$x</a> ";
            }
        }
    }

    if ($paginaCorrente != $numeroPagine) {
        $paginaSuccessiva = $paginaCorrente + 1;
        $output .= " <a class='freccie-speciali' href='{$_SERVER['PHP_SELF']}?page=" . $paginaSuccessiva . "'>></a> ";
        $output .= " <a class='freccie-speciali' href='{$_SERVER['PHP_SELF']}?page=" . $numeroPagine . "'>>></a> ";
    }

    $output .= "</div>";
    return $output;

}
function creaPaginaFooterMateria($numeroPagine, $paginaCorrente, $materia)
{
    $range = 1;
    $output = "<div class='lista-pagine'>";


    if ($paginaCorrente > 1) {
        $output .= " <a class='freccie-speciali' href='{$_SERVER['PHP_SELF']}?page=1&materia=".htmlentities($materia, ENT_QUOTES)."'><<</a> ";
        $paginaPrecedente = $paginaCorrente - 1;
        $output .= " <a class='freccie-speciali' href='{$_SERVER['PHP_SELF']}?page=" . $paginaPrecedente . "&materia=".htmlentities($materia, ENT_QUOTES)."'><</a> ";
    }

    for ($x = ($paginaCorrente - $range); $x < (($paginaCorrente + $range) + 1); $x++) {
        if (($x > 0) && ($x <= $numeroPagine)) {
            if ($x == $paginaCorrente) {
                $output .= " <b>$x</b> ";
            } else {
                $output .= " <a href='{$_SERVER['PHP_SELF']}?page=" . $x . "&materia=".htmlentities($materia, ENT_QUOTES)."'>$x</a> ";
            }
        }
    }

    if ($paginaCorrente != $numeroPagine) {
        $paginaSuccessiva = $paginaCorrente + 1;
        $output .= " <a class='freccie-speciali' href='{$_SERVER['PHP_SELF']}?page=" . $paginaSuccessiva . "&materia=".htmlentities($materia, ENT_QUOTES)."'>></a> ";
        $output .= " <a class='freccie-speciali' href='{$_SERVER['PHP_SELF']}?page=" . $numeroPagine . "&materia=".htmlentities($materia, ENT_QUOTES)."'>>></a> ";
    }

    $output .= "</div>";
    return $output;

}
function creaProfiliStudenti($profiliStudenti)
{
    $nome = $profiliStudenti["nome"];
    $cognome = $profiliStudenti["cognome"];
    $id = $profiliStudenti["fk_id_studente"];
    $descrizioneRichiesta = $profiliStudenti["descrizioneRichiesta"];
    $materia = $profiliStudenti["descrizioneMateria"];
    $comune = $profiliStudenti["nome_comune"];
    $data = $profiliStudenti["data"];
    $immagineProfilo = $profiliStudenti["immagine_profilo"];
    if ($immagineProfilo == "") {
        $immagineProfilo = "../home/profilo/immagini_default/default_profilo.jpg";
    } else {
        $immagineProfilo = "../uploads/" . $immagineProfilo;
    }


    $output = "
    <div class='recensione-utente'>
        <div class='foto-utente-recensione'>
            <img src='" . $immagineProfilo . "' />
        </div>
        <div class='informazioni-recensione'>
            
            <a class='nomeCognomeRecensione'href='studente.php?id=" . $id . "' id='nome'>" . $nome . " " . $cognome . "</a>
            <p id='comune'>" . $comune . "</p>
            
            <p id='materiaRichiesta'><b>{$materia}</b></p>
            <div class='descrizione-valutazione'>
                <p class='descrizioneichiesta'>" . $descrizioneRichiesta . "</p>
            </div>
            <div class='data-valutazione'>" . $data . "</div>
            
        </div>

    </div>
    ";
    return $output;



}

function creaPaginaRisultatiRicerca($risultato, $numeroPagine, $pagina, $navigazione, $profili, $provincia, $listaMaterie)
{

    $output = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='../css/queryStudenti.css'>
        <link rel='stylesheet' href='../css/navbar.css'>
        <link rel='stylesheet' href='../css/richieste.css'>
        <link rel='stylesheet' href='../css/footer.css'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <link rel='shortcut icon' href='../immagini/favicon.ico'/>
        <link rel='shortcut icon' href='http://tutorify.it/immagini/favicon.ico'/>
        <script src='//code.jquery.com/jquery-1.10.2.js'></script>
        <script src='//code.jquery.com/ui/1.11.3/jquery-ui.js'></script>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
        <title>Richieste a {$_SESSION["comune"]}</title>
    </head>
    <body>
   
        <div class='navbar' id='navbar'>
            <a href='../home/dashboard.php' class='active align-left' id='highlited'>TUTORIFY</a>

            <div class='dropdown'>
                <button class='dropbtn'>{$_SESSION["nome"]}
                &#9662;
                </button>
                <div class='dropdown-content'>
                    <a href='../home/classifica.php'>Classifica </a>
                    <a href='../home/profilo/profilo.php'>Profilo </a>
                    <a href='../logout/logout.php' class='logoutButton'>Logout</a>
                </div>
            </div>
            <a href='richieste.php' class='align-right' id='highlited'>Richieste</a>
            <a id='contenitore-ricerca'>
                <div class='barra_ricerca'>
                    <form>
                        <input type='text' id='cercaUtenti' placeholder='Cerca studenti...' autocomplete='off'/>
                        <button type='submit' id='pulsanteCercaUtenti'><i class='fa fa-search'></i></button>
                    </form><br>
                    <div id='listaUtenti'>
                    
                    </div>
                </div>
            </a>
            <a href='javascript:void(0);' style='font-size:15px;' class='icon' onclick='responsive()'>&#9776;</a>
        </div>
        <p id='query'>Ultime richieste a <span>" . $provincia . "</span></p>
        <form action='richieste.php' class='ricercaRichiesteConMateria'>
            <select name='materia' class='listaMaterie'>{$listaMaterie}</select>
            <input class='cercaMateria' type='submit' value='cerca'/>
        </form>
        <div class='contenitore-profili'>
            {$profili}
        </div>
        <div class='navigazione'>
        {$navigazione}
        </div>
        <footer class='footer-distributed'>

            <div class='footer-right'>

            <a href='#'><i class='fa fa-facebook'></i></a>
            <a href='#'><i class='fa fa-twitter'></i></a>
            <a href='#'><i class='fa fa-linkedin'></i></a>

            </div>

            <div class='footer-left'>

            <p class='footer-links'>
                <a class='link-1' href='../index.html'>Home</a>

                <a href='../privacy/privacy.html'>Privacy</a>

                <a href='../contact/contattaci.html'>Contattaci</a>
            </p>

            <p>TUTORIFY &copy; 2020</p>
            </div>

        </footer>
        <script src='../js/responsive.js'></script>
        <script src='../js/ricercaUtenti.js'></script>
    </body>
    </html>

    ";
    return $output;
}
function creaPaginaRisultatiRicercaVuoto($provincia, $materiaScelta)
{
    $output = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
        <script src='https://code.jquery.com/jquery-3.4.1.min.js' integrity='sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=' crossorigin='anonymous'></script>
        <link href='https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css' rel='stylesheet' />
        <script src='https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js'></script>
        <link rel='stylesheet' href='../css/queryStudenti.css'>
        <link rel='stylesheet' href='../css/navbar.css'>
        <link rel='stylesheet' href='../css/footer.css'>
        <link rel='stylesheet' href='../css/animate.css'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <link rel='shortcut icon' href='../immagini/favicon.ico'/>
        <link rel='shortcut icon' href='http://tutorify.it/immagini/favicon.ico'/>
        <title>Richieste a {$_SESSION["comune"]}</title>
    </head>
    <body>
   
        <div class='navbar' id='navbar'>
            <a href='../home/dashboard.php' class='active align-left' id='highlited'>TUTORIFY</a>

            <div class='dropdown'>
                <button class='dropbtn'>{$_SESSION["nome"]}
                &#9662;
                </button>
                <div class='dropdown-content'>
                    <a href='../home/classifica.php'>Classifica </a>
                    <a href='../home/profilo/profilo.php'>Profilo </a>
                    <a href='../logout/logout.php' class='logoutButton'>Logout</a>
                </div>
            </div>
            <a href='richieste.php' class='align-right' id='highlited'>Richieste</a>
            <a id='contenitore-ricerca'>
                <div class='barra_ricerca'>
                    <form>
                        <input type='text' id='cercaUtenti' placeholder='Cerca studenti...' autocomplete='off'/>
                        <button type='submit' id='pulsanteCercaUtenti'><i class='fa fa-search'></i></button>
                    </form><br>
                    <div id='listaUtenti'>
                    
                    </div>
                </div>
            </a>
            <a href='javascript:void(0);' style='font-size:15px;' class='icon' onclick='responsive()'>&#9776;</a>
        </div>
        <div class='contenitore-errore'>
        <p id='erroreScritta'>Non ci sono richieste ".$materiaScelta." a " . $provincia . "</p>
           <img src='../immagini/studentiNonTrovati.svg' />
           <a href='richieste.php'>Torna alle richieste</a>
        </div>
        <footer class='footer-distributed'>

            <div class='footer-right'>

            <a href='#'><i class='fa fa-facebook'></i></a>
            <a href='#'><i class='fa fa-twitter'></i></a>
            <a href='#'><i class='fa fa-linkedin'></i></a>

            </div>

            <div class='footer-left'>

            <p class='footer-links'>
                <a class='link-1' href='../index.html'>Home</a>

                <a href='../privacy/privacy.html'>Privacy</a>

                <a href='../contact/contattaci.html'>Contattaci</a>
            </p>

            <p>TUTORIFY &copy; 2020</p>
            </div>

        </footer>
        <script src='../js/responsive.js'></script>
        <script src='../js/ricercaUtenti.js'></script>
    </body>
    </html>

    ";
    return $output;
}


?>