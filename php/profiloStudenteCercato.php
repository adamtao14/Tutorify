<?php
function creaRecensioni($recensioniStudente)
{
    $recensioni = "";
    $sommaValutazioni = 0;
    if (empty($recensioniStudente)) {
        $mediaValutazioni = 0;
        $stellePieneMedia = 0;
    } else {
        for ($i = 0; $i < count($recensioniStudente); $i++) {
            $sommaValutazioni += $recensioniStudente[$i]["valutazione"];
        }
        $mediaValutazioni = $sommaValutazioni / count($recensioniStudente);
        $mediaValutazioni = round($mediaValutazioni, 1);
        $stellePieneMedia = floor($mediaValutazioni);
    }

    $mediaValutazioniTesto = "";

    $mediaValutazioniTesto .= "<div class='valutazione-stelle'><div class='stelle'>";
    for ($k = 0; $k < $stellePieneMedia; $k++) {
        $mediaValutazioniTesto .= "<i class='fa fa-star'></i>";
    }
    if ($mediaValutazioni > $stellePieneMedia) {
        $mediaValutazioniTesto .= "<i class='fa fa-star-half-o'></i>";
        $stelleRimaste = 5 - ($stellePieneMedia + 1);
    } else {
        $stelleRimaste = 5 - $stellePieneMedia;
    }
    if ($stelleRimaste > 0) {
        for ($k = 0; $k < $stelleRimaste; $k++) {
            $mediaValutazioniTesto .= "<i class='fa fa-star-o'></i>";
        }
    }
    $mediaValutazioniTesto .= "
    </div>
    </div>
    <div class='informazioni-recensione media'><a href='' id='mediaScritta'> Media " . number_format($mediaValutazioni, 1, '.', '') . "</a>";
    if(empty($recensioniStudente)){
        $mediaValutazioniTesto .= "</div>";
    }else{
        $mediaValutazioniTesto .= "<img src='../immagini/scroll.gif' id='scroll' /></div>";
    }
    
    $recensioni .= $mediaValutazioniTesto;

    if (!empty($recensioniStudente)) {
        for ($i = 0; $i < count($recensioniStudente); $i++) {
            $idStudenteRecensione = $recensioniStudente[$i]["fk_id_scrittore_recensione"];
            $immagineProfilo = $recensioniStudente[$i]["immagine_profilo"];
            if ($immagineProfilo == "") {
                $immagineProfilo = "../home/profilo/immagini_default/default_profilo.jpg";
            } else {
                $immagineProfilo = "../uploads/" . $immagineProfilo;
            }
            $recensioni .= "
            <div class='recensione-utente'>
            <div class='foto-utente-recensione'>
                <img src='" . $immagineProfilo . "' />
            </div>
            <div class='informazioni-recensione'>";
            $recensioni .= "<a class='nomeCognomeRecensione' href='studente.php?id=" . $recensioniStudente[$i]["fk_id_scrittore_recensione"] . "'>" . $recensioniStudente[$i]["nome"] . " " . $recensioniStudente[$i]["cognome"] . "</a>";
            $recensioni .= "
                <div class='data-valutazione'>
                    " . $recensioniStudente[$i]["data"] . "
                </div>
            
            ";
            $valutazione = $recensioniStudente[$i]["valutazione"];
            $numeroStellePiene = floor($valutazione);
            $recensioni .= "<div class='valutazione-stelle'><div class='stelle'>";
            for ($k = 0; $k < $numeroStellePiene; $k++) {
                $recensioni .= "<i class='fa fa-star'></i>";
            }
            if ($valutazione > $numeroStellePiene) {
                $recensioni .= "<i class='fa fa-star-half-o'></i>";
                $stelleRimaste = 5 - ($numeroStellePiene + 1);
            } else {
                $stelleRimaste = 5 - $numeroStellePiene;
            }
            if ($stelleRimaste > 0) {
                for ($k = 0; $k < $stelleRimaste; $k++) {
                    $recensioni .= "<i class='fa fa-star-o'></i>";
                }
            }
            $recensioni .= "</div></div>";
            $recensioni .= "
            <div class='descrizione-valutazione'>
            <p class='descrizioneRecensione'>" . $recensioniStudente[$i]["descrizione"] . "</p>
            ";
            if($idStudenteRecensione == $_SESSION["id"]){
                $recensioni .= "<p class='eliminaRecensione' onClick='eliminaRecensione(".$recensioniStudente[$i]["ID"].")'>Elimina</p>";
            }
            $recensioni .= "</div></div></div>";
            
        }

    }
    return $recensioni;
}
function creaPaginaProfiloStudenteCercato($nome, $cognome, $immagineProfilo, $bannerProfilo, $numClasse, $comune, $scuola, $descrizione, $eta, $indirizzo, $materie, $idStudente, $recensioni, $numeroRecensioni, $telefono, $email)
{

    $contenuto = "";
    if($descrizione == ""){
        $descrizione = "<p id='nessuna_descrizione'>" . $nome . " non ha fornito una descrizione</p>";
    }
    if ($materie == "") {
        $contenuto = "<p id='nessuna_materia'>" . $nome . " non ha selezionato nessuna materia</p>";
    } else {
        $materieSplittate = explode("-", $materie);
        for ($i = 0; $i < sizeof($materieSplittate); $i++) {
            $contenuto .= "<li class='materia'><p>" . $materieSplittate[$i] . "</p></li>";
        }
    }
    if($telefono==""){
        $scrittaTelefono = "";
    }else{
        $scrittaTelefono = "
        <p id='telefonoScritta'>
            <i class='fa fa-phone'></i> +39 ".$telefono."</p>
        <p id='oppure'>Oppure</p>";
    }
    $contenutoRichieste = "";
    $richiesteStudente = ottieniRichiesteStudente($idStudente);
    if(count($richiesteStudente) > 0){

        $contenutoRichieste .= "
        <div class='modifica-materie'>
            <h1>Richieste attive</h1>
            <div class='contenitore-materie'>    
                <table class='tabellaRichiesteMaterie'>
                    <tr>
                        <th>Richiesta</th>
                        <th>Descrizione</th>
                        <th>Data</th>
                    </tr>
        ";
        for ($i = 0; $i < sizeof($richiesteStudente); $i++) {
            $contenutoRichieste .="
            <tr id='richiesta{$i}'>
                <td class='nomeMateriaRichiesta'>".$richiesteStudente[$i]["descrizioneMateria"]."</td>
                <td>".$richiesteStudente[$i]["descrizioneRichiesta"]."</td>
                <td>".$richiesteStudente[$i]["data"]."</td>
            </tr>";
        }
        $contenutoRichieste .= "</div></div></table></div>";
    }

    $html = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link rel='stylesheet' href='../css/profilo.css'>
        <link rel='stylesheet' href='../css/navbar.css'>
        <link rel='stylesheet' href='../css/footer.css'>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <link rel='shortcut icon' href='../immagini/favicon.ico'/>
        <link rel='shortcut icon' href='http://tutorify.it/immagini/favicon.ico'/>
        <script src='//code.jquery.com/jquery-1.10.2.js'></script>
        <meta charset='UTF-8'>
        <meta http-equiv='Content-type' content='text/html; charset=UTF-8'>
        <title>Profilo di {$nome}</title>
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
        <div class='profilo-header header-lungo'>
                <div class='profilo-header-banner' style='background-image:url()'>
                    <img src='{$bannerProfilo}'id='tag_immagine_banner' />
                </div>
                <div class='profilo-header-foto' style='background-image:url({$immagineProfilo})'>
                    
                </div>
                <p class='nome'>{$nome} {$cognome}</p>
                <p class='luogo'>{$comune}</p>
                <button id='pulsanteContatta' class='pulsanteRecensione'>Contatta</button>
                <div id='contatta' class='modal'>

                    <div class='modal-content'>
                        <span id='chiudiContatta' class='close'>&times;</span>
                        <p id='scrittaValuta'>Contatta ".$nome."</p>
                        ".
                            $scrittaTelefono
                        ."
                        <p id='telefonoScritta'><span>&#9993</span> ".$email."</p>
                    </div>

                </div>
            
        </div>
        <div class='contenitore'>
            
            <div class='bio-descrizione'>
                <div class='bio'>
                <table class='table-bio'>
                    <tr>
                        <td class='nomeInfo'><p><b>Scuola:</b></p></td>
                        <td><p>{$scuola}</p></td>
                    </tr>
                    <tr>
                        <td class='nomeInfo'><p><b>Anno:</b></p></td>
                        <td><p>{$numClasse}</p></td>
                    </tr>
                    <tr>
                        <td class='nomeInfo'><p><b>Indirizzo:</b></p></td>
                        <td><p>{$indirizzo}</p></td>
                    </tr>
                    <tr>
                        <td class='nomeInfo'><p><b>Età:</b></p></td>
                        <td><p>{$eta}</p></td>
                    </tr>

                </table>
                </div>
                <div class='descrizione'>
                    <h1>Descrizione</h1>
                    <p>
                    {$descrizione}
                    </p>
                </div>
            </div>
            <div class='alert' id='recNonCaricata'>
                <strong>Ops!</strong> La recensione non è stata caricata correttamente
            </div>
            <div class='alert success' id='recCaricata'>
                <strong>Ottimo!</strong> La tua recensione è stata caricata con successo
            </div>
            <div class='alert warning' id='recEsistente'>
                <strong>Attenzione!</strong> Hai già dato una recensione allo studente
            </div>
            <div class='alert' id='recNonEliminata'>
                <strong>Ops!</strong> La recensione non è stata eliminata 
            </div>
            <div class='alert success' id='recEliminata'>
                <strong>Ottimo!</strong> La tua recensione è stata eliminata con successo
            </div>
            <div class='materie-valutazione'>
                <div class='valutazione'>
                    <h1>".$numeroRecensioni." Recensioni</h1>
                    <button id='pulsanteRecensione' class='pulsanteRecensione'>Valuta</button>
                    <div id='valutazione' class='modal'>

                    <div class='modal-content'>
                    <form>
                        <span id='chiudiValutazione' class='close'>&times;</span>
                        <p id='scrittaValuta'>Valuta {$nome}</p>
                        <div class='slidecontainer'>
                            <input type='range' min='0.5' max='5' value='5' class='slider' id='rangeValutazione' step='0.5' name='valutazione'>
                            <p><span id='demo'></span>/5</p>
                        </div>
                        <textarea id='descrizioneRecensione' name='descrizione' placeholder='Descrizione...'></textarea>
                        <input type='button' class='pulsanteRecensione' id='valuta' value='Valuta' name='valuta'>
                    </form>
                    </div>

                    </div>
                    {$recensioni}
                    
                </div>
                <div class='materie-utente'>
                    <ol>
                        {$contenuto}
                    </ol>
                </div>
            </div>
            {$contenutoRichieste}
            
        </div>
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

                <a href='#'>Contattaci</a>
            </p>

            <p>TUTORIFY &copy; 2020</p>
            </div>

        </footer>

        <script src='../js/responsive.js'></script>
        <script src='../js/popupValutazione.js'></script>
        <script src='../js/ricercaUtenti.js'></script>
        <script src='../js/contatta.js'></script>
        <script src='../js/aggiungiRecensione.js'></script>
        <script src='../js/eliminaRecensione.js'></script>
    </body>
    </html>
    ";
    return $html;

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
        <p>Lo studente non esiste </p>
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