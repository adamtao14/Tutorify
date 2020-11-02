<?php
include("dbconnection.php");
$GLOBALS['dbConn'] = $db_connection;

function queryStudentiRicercaTotale($idMateria, $idResidenza)
{
    $sql = "SELECT studenti.ID
            FROM materie_studenti,studenti,comuni,materie
            WHERE materie.ID = :idMateria 
            AND materie_studenti.fk_id_studente = studenti.ID
            AND materie_studenti.fk_id_materia =:idMateria 
            AND comuni.ID = studenti.residenza
            AND studenti.ID != :idStudente
            AND comuni.id_provincia = :idResidenza
            ";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idResidenza', $idResidenza);
    $stmt->bindParam(':idMateria', $idMateria);
    $stmt->bindParam(':idStudente', $_SESSION["id"]);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function queryStudentiRicercaLimite($idMateria, $idResidenza, $primoRisultatoPagina, $risultatiPerPagina)
{
    $sql = "SELECT studenti.nome,studenti.cognome,studenti.ID,materie.descrizione,comuni.nome_comune,studenti.immagine_profilo,studenti.telefono
            FROM materie_studenti,studenti,comuni,materie
            WHERE materie.ID = :idMateria 
            AND materie_studenti.fk_id_studente = studenti.ID
            AND materie_studenti.fk_id_materia =:idMateria 
            AND comuni.ID = studenti.residenza
            AND studenti.ID != :idStudente
            AND comuni.id_provincia = :idResidenza
            LIMIT " . $primoRisultatoPagina . "," . $risultatiPerPagina . "";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idResidenza', $idResidenza);
    $stmt->bindParam(':idMateria', $idMateria);
    $stmt->bindParam(':idStudente', $_SESSION["id"]);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function queryMaterieStudente($id){
    $sql = "SELECT materie.descrizione,studenti.nome,studenti.ID
            FROM studenti,materie_studenti,materie
            WHERE materie_studenti.fk_id_studente = studenti.ID
            AND studenti.ID=:idStudente
            AND materie_studenti.fk_id_materia = materie.ID;
    ";
     $stmt = $GLOBALS['dbConn']->prepare($sql);
     $stmt->bindParam(':idStudente', $id);
     $stmt->execute();
     $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
     return $rows;
}
function queryStudentiRicercaNavbar($query){
    $sql = "SELECT studenti.ID,studenti.nome,studenti.cognome
            FROM studenti
            WHERE (studenti.nome LIKE '".$query."%'
            OR studenti.cognome LIKE '".$query."%'
            OR CONCAT(studenti.nome,' ',studenti.cognome) LIKE '".$query."%')
            AND studenti.ID != ".$_SESSION["id"]."
            LIMIT 10";
            
     $stmt = $GLOBALS['dbConn']->query($sql);
     $stmt->execute();
     $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
     return $rows;
}
function creaPaginaFooter($numeroPagine, $paginaCorrente, $materia, $provincia)
{
    $range = 1;
    $output = "<div class='lista-pagine'>";

    
    if ($paginaCorrente > 1) {
        $output .= " <a class='freccie-speciali' href='{$_SERVER['PHP_SELF']}?materia=" . $materia . "&provincia=" . htmlentities($provincia, ENT_QUOTES)  . "&submit=cerca&page=1'><<</a> ";
        $paginaPrecedente = $paginaCorrente - 1;
        $output .= " <a class='freccie-speciali' href='{$_SERVER['PHP_SELF']}?materia=" . $materia . "&provincia=" . htmlentities($provincia, ENT_QUOTES)  . "&submit=cerca&page=" . $paginaPrecedente . "'><</a> ";
    }
    
    for ($x = ($paginaCorrente - $range); $x < (($paginaCorrente + $range) + 1); $x++) {
        if (($x > 0) && ($x <= $numeroPagine)) {
            if ($x == $paginaCorrente) {
                $output .= " <b>$x</b> ";
            } else {
                $output .= " <a href='{$_SERVER['PHP_SELF']}?materia=" . $materia . "&provincia=" . htmlentities($provincia, ENT_QUOTES) . "&submit=cerca&page=".$x."'>$x</a> ";
            }
        }
    }
                           
    if ($paginaCorrente != $numeroPagine) {
        $paginaSuccessiva = $paginaCorrente + 1;
        $output .= " <a class='freccie-speciali' href='{$_SERVER['PHP_SELF']}?materia=" . $materia . "&provincia=" . htmlentities($provincia, ENT_QUOTES)  . "&submit=cerca&page=".$paginaSuccessiva."'>></a> ";
       $output .= " <a class='freccie-speciali' href='{$_SERVER['PHP_SELF']}?materia=" . $materia . "&provincia=" . htmlentities($provincia, ENT_QUOTES)  . "&submit=cerca&page=".$numeroPagine."'>>></a> ";
    }

    $output .= "</div>";
    return $output;

}
function creaProfiliStudenti($profiliStudenti,$materieStudente){
    $nome = $profiliStudenti["nome"];
    $cognome = $profiliStudenti["cognome"];
    $id = $profiliStudenti["ID"];
    $materia = $profiliStudenti["descrizione"];
    $comune = $profiliStudenti["nome_comune"];
    $immagineProfilo = $profiliStudenti["immagine_profilo"];
    if($immagineProfilo == ""){
        $immagineProfilo = "../home/profilo/immagini_default/default_profilo.jpg";
    }else{
        $immagineProfilo = "../uploads/".$immagineProfilo;
    }
    $listaMaterie = "";
    $numeroMaterie = count($materieStudente);
    if($numeroMaterie > 3){
        $listaMaterie .= 
        "   
        <li>".$materieStudente[0]["descrizione"]."</li>
        <li>".$materieStudente[1]["descrizione"]."</li>
        <li>".$materieStudente[2]["descrizione"]."</li>
        <li> + altre ".($numeroMaterie - 3)." materie</li>
        
        ";
    }else{
        for($i = 0; $i < $numeroMaterie; $i++){
            $listaMaterie .= "<li>".$materieStudente[$i]["descrizione"]."</li>"; 
        }
    }
    
    $output = "
    <div class='profilo'>
        <div class='immagine'>
            <img src='".$immagineProfilo."' />
        </div>
        <div class='intestazione'>
            
            <a href='studente.php?id=".$id."' id='nome'>".$nome." ".$cognome."</a>
            <p id='comune'>".$comune."</p>
            <p><i>Ti può aiutare in </i></p>
            <ul>
                {$listaMaterie}
            </ul>
        </div>

    </div>
    ";
    return $output;
    


}

function creaPaginaRisultatiRicerca($risultato, $numeroPagine, $pagina, $navigazione, $profili, $materia, $provincia, $numeroRisultatiPagina)
{

    $output = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link rel='stylesheet' href='../css/queryStudenti.css'>
        <link rel='stylesheet' href='../css/navbar.css'>
        <link rel='stylesheet' href='../css/animate.css'>
        <link rel='stylesheet' href='../css/footer.css'>
        <link rel='shortcut icon' href='../immagini/favicon.ico'/>
        <link rel='shortcut icon' href='http://tutorify.it/immagini/favicon.ico'/>
        <script src='https://code.jquery.com/jquery-3.4.1.min.js' integrity='sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=' crossorigin='anonymous'></script>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <title>Profilo di {$_SESSION["nome"]}</title>
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
            <a href='richieste.php' class='align-right'>Richieste</a>
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
        <div class='wrapper-pagina'>
        <p id='query'>Risultati per <span>".$materia."</span> a <span>".$provincia."</span></p>
        <div class='contenitore-profili'>
            {$profili}
        </div>
        <div class='navigazione'>
        {$navigazione}
        </div>
        </div>
        ";
        /*if($numeroRisultatiPagina < 2){
            $output .= "<footer class='footer-distributed' style='position:absolute;'>";
        }else{
            $output .= "<footer class='footer-distributed' style='position:relative;'>";
        }*/
        

        $output .= "
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
function creaPaginaRisultatiRicercaVuoto(){
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
        <link rel='stylesheet' href='../css/animate.css'>
        <link rel='stylesheet' href='../css/footer.css'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <link rel='shortcut icon' href='../immagini/favicon.ico'/>
        <link rel='shortcut icon' href='http://tutorify.it/immagini/favicon.ico'/>
        <title>Profilo di {$_SESSION["nome"]}</title>
    </head>
    <body>
   
        <div class='navbar' id='navbar'>
            <a href='../home/dashboard.php' class='active align-left' id='highlited'>TUTORIFY</a>

            <div class='dropdown'>
                <button class='dropbtn'>{$_SESSION["nome"]}
                    <i class='fa fa-caret-down'></i>
                </button>
                <div class='dropdown-content'>
                    <a href='../home/classifica.php'>Classifica </a>
                    <a href='../home/profilo/profilo.php'>Profilo </a>
                    <a href='../logout/logout.php' class='logoutButton'>Logout</a>
                </div>
            </div>
            <a href='richieste.php' class='align-right'>Richieste</a>
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
        <p>Ci dispiace ma non abbiamo trovato studenti </p>
           <img src='../immagini/studentiNonTrovati.svg' />
           <a href='../home/dashboard.php'>Torna nella dashboard</a>
        </div>
        <footer class='footer-distributed' >

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