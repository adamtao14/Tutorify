<?php
include("dbconnection.php");
include("profiloStudenteCercato.php");

function creaRecensioniProfilo($recensioniStudente)
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
        $mediaValutazioniTesto .= "<img src='../../immagini/scroll.gif' id='scroll' /></div>";
    }
    
    $recensioni .= $mediaValutazioniTesto;

    if (!empty($recensioniStudente)) {
        for ($i = 0; $i < count($recensioniStudente); $i++) {
            $immagineProfilo = $recensioniStudente[$i]["immagine_profilo"];
            if ($immagineProfilo == "") {
                $immagineProfilo = "immagini_default/default_profilo.jpg";
            } else {
                $immagineProfilo = "../../uploads/" . $immagineProfilo;
            }
            $recensioni .= "
            <div class='recensione-utente'>
            <div class='foto-utente-recensione'>
                <img src='" . $immagineProfilo . "' />
            </div>
            <div class='informazioni-recensione'>
            <a class='nomeCognomeRecensione' href='../../php/studente.php?id=" . $recensioniStudente[$i]["fk_id_scrittore_recensione"] . "'>" . $recensioniStudente[$i]["nome"] . " " . $recensioniStudente[$i]["cognome"] . "</a>";
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
            $recensioni .= "</div></div></div>";
        }

    }
    return $recensioni;
}
function creaPaginaProfilo($recensioniHtml, $numeroRecensioni)
{

    $contenuto="";
    $materie = ottieniMaterieStudenti($_SESSION["id"]);
    $_SESSION["materie"] = $materie;
    if ($_SESSION["materie"] == "Nessuna materia selezionata" || $_SESSION["materie"] == "" ) {
        $contenuto = "<p id='nessuna_materia'>Non hai indicato nessuna materia</p>";
    } else {
        $materie = explode("-", $_SESSION["materie"]);
        for ($i = 0; $i < sizeof($materie); $i++) {
            $contenuto .="<li class='materia'><p>".$materie[$i]."</p></li>";
        }
    }
    $contenutoRichieste = "";
    $richiesteStudente = ottieniRichiesteStudente($_SESSION["id"]);
    if(count($richiesteStudente) > 0){

        $contenutoRichieste .= "
        <div class='modifica-materie'>
            <h1>Richieste attive</h1>
            <div class='contenitore-materie'>    
                <table class='tabellaRichiesteMaterie'>
                    <tr>
                        <th>#</th>
                        <th>Richiesta</th>
                        <th>Data</th>
                    </tr>
        ";
        for ($i = 0; $i < sizeof($richiesteStudente); $i++) {
            $contenutoRichieste .="
            <tr id='richiesta{$i}'>
                <td>".($i+1)."</td>
                <td class='nomeMateriaRichiesta'>".$richiesteStudente[$i]["descrizioneMateria"]."</td>
                
                <td>".$richiesteStudente[$i]["data"]."</td>
            </tr>";
        }
        $contenutoRichieste .= "</div></div></table></div>";
    }
    $html = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <script src='//code.jquery.com/jquery-1.10.2.js'></script>
        <script src='//code.jquery.com/ui/1.11.3/jquery-ui.js'></script>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link rel='stylesheet' href='../../css/profilo.css'>
        <link rel='stylesheet' href='../../css/navbar.css'>
        <link rel='stylesheet' href='../../css/footer.css'>
        <link rel='shortcut icon' href='../../immagini/favicon.ico'/>
        <link rel='shortcut icon' href='http://tutorify.it/immagini/favicon.ico'/>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <title>Profilo di {$_SESSION["nome"]}</title>
    </head>
    <body>
        <div class='navbar' id='navbar'>
            <a href='../dashboard.php' class='active align-left' id='highlited'>TUTORIFY</a>

            <div class='dropdown'>
            <button class='dropbtn' id='highlited'>{$_SESSION["nome"]}
                &#9662;
                </button>
                <div class='dropdown-content'>
                    <a href='../classifica.php'>Classifica</a>
                    <a href='profilo.php'>Profilo</a>
                    <a href='../../logout/logout.php' class='logoutButton'>Logout</a>
                </div>
            </div>
            <a href='../../php/richieste.php' class='align-right'>Richieste</a>
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
        <div class='profilo-header'>
                <div class='profilo-header-banner'>
                    <img src='{$_SESSION["banner_profilo"]}'/>
                </div>
                <div class='profilo-header-foto' style='background-image:url({$_SESSION["immagine_profilo"]})'>

                </div>
                <p class='nome'>{$_SESSION["nome"]} {$_SESSION["cognome"]}</p>
                <p class='luogo'>{$_SESSION["comune"]}</p>
                <a href='modificaProfilo.php' id='modifica'>Modifica</a>
        </div>
        <div class='contenitore'>
            
            <div class='bio-descrizione'>
                <div class='bio'>
                    <table class='table-bio'>
                        <tr>
                            <td class='nomeInfo'><p><b>Scuola:</b></p></td>
                            <td><p>{$_SESSION["scuola"]}</p></td>
                        </tr>
                        <tr>
                            <td class='nomeInfo'><p><b>Anno:</b></p></td>
                            <td><p>{$_SESSION["num_classe"]}</p></td>
                        </tr>
                        <tr>
                            <td class='nomeInfo'><p><b>Indirizzo:</b></p></td>
                            <td><p>{$_SESSION["nome_indirizzo"]}</p></td>
                        </tr>
                        <tr>
                            <td class='nomeInfo'><p><b>Età:</b></p></td>
                            <td><p>{$_SESSION["eta"]}</p></td>
                        </tr>

                    </table>
                </div>
                <div class='descrizione'>
                    <h1>Descrizione</h1>
                    <p>
                    {$_SESSION["descrizione"]}
                    </p>
                </div>
            </div>
            <div class='materie-valutazione'>
                <div class='valutazione'>
                    <h1>".$numeroRecensioni." Recensioni</h1>
                    {$recensioniHtml}
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
                <a class='link-1' href='../../index.html'>Home</a>

                <a href='../../privacy/privacy.html'>Privacy</a>

                <a href='../../contact/contattaci.html'>Contattaci</a>
            </p>

            <p>TUTORIFY &copy; 2020</p>
            </div>

        </footer>

        <script src='../../js/responsive.js'></script>
        <script src='../../js/ricercaUtenti.js'></script>
    </body>
    </html>
    ";
    return $html;
}

function creaPaginaModificaProfilo()
{
    $listaClassi = ottieniClassi($_SESSION["num_classe"]);
    $listaIndirizzi = ottieniIndirizzi($_SESSION["nome_indirizzo"]);
    $listaMaterie = ottieniMaterie();
    $materie = ottieniMaterieStudenti($_SESSION["id"]);
    $telefono = ottieniNumeroTelefono($_SESSION["id"]);
    $_SESSION["materie"] = $materie;
    $contenutoMaterie = "";
    $contenutoRichieste = "";
    if ($_SESSION["materie"] != "Nessuna materia selezionata" && $_SESSION["materie"] != "" ) {
        
        $materie = explode("-", $_SESSION["materie"]);
        $contenutoMaterie .= "
        <table class='tabellaRichiesteMaterie'>
            <tr>
                <th>Materia</th>
                <th>Operazioni</th>
            </tr>
        ";
        for ($i = 0; $i < sizeof($materie); $i++) {
            $contenutoMaterie .="
            <tr id='materia{$i}'>
                <td>".$materie[$i]."</td>
                <td><p onClick='eliminaMateria({$i},\"$materie[$i]\")'>Elimina</p>
            </tr>";
        }
        $contenutoMaterie .= "</table><br>";
        
    }
    $contenutoMaterie .= "<p>Aggiungi materie</p>
    <select class='js-example-basic-single' id='listaMaterie' name='materie[]' multiple='multiple' style='width:100%;margin-left:100px;'>"
    .$listaMaterie.
    "</select>";
    $richiesteStudente = ottieniRichiesteStudente($_SESSION["id"]);
    if(count($richiesteStudente) > 0){
        $contenutoRichieste .= "
        <div class='modifica-materie'>
            <h1>Richieste</h1>
            <div class='contenitore-materie'>
                <table class='tabellaRichiesteMaterie'>
                    <tr>
                        <th>Richiesta</th>
                        <th>Data</th>
                        <th>Operazioni</th>
                    </tr>
        ";
        for ($i = 0; $i < sizeof($richiesteStudente); $i++) {
            $contenutoRichieste .="
            <tr id='richiesta{$i}'>
                <td>".$richiesteStudente[$i]["descrizioneMateria"]."</td>
                <td>".$richiesteStudente[$i]["data"]."</td>
                <td><p onClick='eliminaRichiesta({$richiesteStudente[$i]["ID"]},{$i})'>Elimina</p>
            </tr>";
        }
        $contenutoRichieste .= " </div></div></table></div>";
    }
    
    $html = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <script src='https://code.jquery.com/jquery-3.4.1.min.js' integrity='sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=' crossorigin='anonymous'></script>
        <link href='https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css' rel='stylesheet' />
        <script src='https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js'></script>
        <script src='https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.min.js'></script>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.4/croppie.css'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
        <link rel='stylesheet' href='../../css/modificaProfilo.css'>
        <link rel='stylesheet' href='../../css/animate.css'>
        <link rel='stylesheet' href='../../css/navbar.css'>
        <link rel='stylesheet' href='../../css/footer.css'>
        <link rel='shortcut icon' href='../../immagini/favicon.ico'/>
        <link rel='shortcut icon' href='http://tutorify.it/immagini/favicon.ico'/>
        <meta http-equiv='X-UA-Compatible' content='ie=edge'>
        <title>Profilo di {$_SESSION["nome"]}</title>
    </head>
    <body>
   
        <div class='navbar' id='navbar'>
            <a href='../dashboard.php' class='active align-left' id='highlited'>TUTORIFY</a>

            <div class='dropdown'>
                <button class='dropbtn' id='highlited'>{$_SESSION["nome"]}
                &#9662;
                </button>
                <div class='dropdown-content'>
                    <a href='../classifica.php'>Classifica</a>
                    <a href='profilo.php'>Profilo </a>
                    <a href='../../logout/logout.php' class='logoutButton'>Logout</a>
                </div>
            </div>
            <a href='../../php/richieste.php' class='align-right'>Richieste</a>
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

        <form action='../../php/modificaDatiProfilo.php' method='POST' enctype='multipart/form-data'>
        <div class='profilo-header'>
                <div class='profilo-header-banner' id='banner_profilo'>
                <p onclick='triggerImmagineBanner()'>Modifica</p>
                    <input type='file' name='immagine_banner' id='immagine_banner' accept='image/*'/>
                    <img src='{$_SESSION["banner_profilo"]}'id='tag_immagine_banner' />
                    
                </div>
                <div class='profilo-header-foto' id='immagine_profilo' style='background-image:url({$_SESSION["immagine_profilo"]})'>
                    <p onclick='triggerImmagineFotoProfilo()'>Modifica</p>
                    <input type='file' name='immagine_foto_profilo' id='immagine_foto_profilo' accept='image/*'/>
                </div>
                <p class='nome'><input type='text' name ='nome' value='".htmlentities($_SESSION["nome"], ENT_QUOTES)."' required/> <input type='text' name = 'cognome' value='".htmlentities($_SESSION["cognome"], ENT_QUOTES)."' required/> </p>
                <p class='luogo'><input type='text' name='comune' id='comune' value='".htmlentities($_SESSION["comune"], ENT_QUOTES)."' required/></p>
                <div id='listaComuni' class='animated zoomIn risultati'>

                </div>
                <a href='eliminaProfilo.php' id='eliminaProfilo'>Elimina profilo</a>
            </div>
            <div id='preview-foto-profilo' class='modal'>
                <div class='modal-content' id='box-preview-foto-profilo'>
                    
                    <span class='close' id='chiudi-preview-foto-profilo'>&times;</span>
                    <b>Ritaglia immagine</b>
                    <div id='ritaglio-immagine-profilo' style='width:90%; margin-top:30px'></div>

                    <br>
                    <br>
                    <br>
                    <button class='pulsante_conferma_ritaglio' id='pulsante_conferma_ritaglio_foto_profilo'>Conferma</button>
                </div>
            </div>
            <div id='preview-banner-profilo' class='modal'>
                <div class='modal-content' id='box-preview-banner-profilo'>
                    
                    <span class='close' id='chiudi-preview-banner-profilo'>&times;</span>
                    <b>Ritaglia immagine</b>
                    <div id='ritaglio-banner-profilo' style='width:90%; margin-top:30px;margin-left:auto;margin-right:auto;'></div>

                    <br>
                    <br>
                    <br>
                    <button class='pulsante_conferma_ritaglio' id='pulsante_conferma_ritaglio_banner_profilo'>Conferma</button>
                </div>
            </div>
        <div class='contenitore'>
            
            <div class='bio-descrizione'>
                <div class='bio'>
                <table id='table-bio'>
                    <tr>
                        <td><b>Scuola:</b>
                        <td>
                           <input type='text' name='scuola' value='".$_SESSION["scuola"]."' id='scuola' />
                            <div id='listaScuole' class='animated zoomIn risultati'>

                            </div>

                        </td>
                    </tr>
                    
                    <tr>
                        <td><b>Anno:</b></td>
                        <td><select name='classe' required>
                            {$listaClassi}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Indirizzo:</b></td>
                        <td>
                            <select name='indirizzo' id = 'indirizzi' required>
                                {$listaIndirizzi}
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><b>Data di nascita:</b></td>
                        <td><input type='date' name='dataNascita' value={$_SESSION["data_nascita"]} /></td>
                    </tr>
                    <tr>
                        <td><b>Telefono:</b></td>
                        <td><input type='text' name='telefono' value='".$telefono."' id='telefono'/></td>
                    </tr>
                </table>
                </div>
                <div class='descrizione'>
                    <h1>Descrizione</h1>
                        <textarea name='descrizione'>{$_SESSION["descrizione"]}</textarea>
                </div>
            
            </div>
            <div class='modifica-materie'>
                <h1>Materie</h1>
                <div class='contenitore-materie'>
                    
                    {$contenutoMaterie}
                </div>
            </div>  
            {$contenutoRichieste}

            

        </div>
        </div>
        <input type='submit' value='Modifica'/>
        </form>
        <footer class='footer-distributed'>

            <div class='footer-right'>

            <a href='#'><i class='fa fa-facebook'></i></a>
            <a href='#'><i class='fa fa-twitter'></i></a>
            <a href='#'><i class='fa fa-linkedin'></i></a>

            </div>

            <div class='footer-left'>

            <p class='footer-links'>
                <a class='link-1' href='../../index.html'>Home</a>

                <a href='../../privacy/privacy.html'>Privacy</a>

                <a href='../../contact/contattaci.html'>Contattaci</a>
            </p>

            <p>TUTORIFY &copy; 2020</p>
            </div>

        </footer>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            }); 
        </script>
        

        <script src='../../js/responsive.js'></script>
        <script src='../../js/ricercaComuniModificaProfilo.js'></script>
        <script src='../../js/modificaImmagini.js'></script>
        <script src='../../js/eliminaMaterie.js'></script>
        <script src='../../js/ricercaUtenti.js'></script>
        <script src='../../js/eliminaRichiesta.js'></script>
        <script src='../../js/ricercaScuoleModificaProfilo.js'></script>
    </body>
    </html>
    ";
    return $html;
}

?>