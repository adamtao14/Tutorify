<?php
session_start();
include("../php/funzioniQuery.php");
include("../php/sessionExpiration.php");

//controllo stato sessione
if (isset($_SESSION["id"])) {
    if (isLoginSessionExpired()) {
        header("Location:../logout/logout.php?sessione_scaduta=1");
    } else {
        if ($_SESSION["profilo_completato"] == 0) {
            header("Location:../completamento/completaRegistrazione.php");
        }
    }
    //ottengo le materie e le province da inserire nelle select
    $materie = ottieniMaterie();
    $provincie = ottieniProvincie();
} else {
    header("Location:../login/accedi.php");
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/dashboard.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel='shortcut icon' href='../immagini/favicon.ico'/>
    <link rel='shortcut icon' href='http://tutorify.it/immagini/favicon.ico'/>
    <script src='//code.jquery.com/jquery-1.10.2.js'></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard di <?php print($_SESSION["nome"]); ?></title>
</head>
<body>
    <div class="navbar" id="navbar">
        <a href="dashboard.php" class="active align-left" id="logo">TUTORIFY</a>
        
        <div class="dropdown">
            <button class="dropbtn"><?php print($_SESSION["nome"]); ?> 
            &#9662;
            </button>
            <div class="dropdown-content">
                <a href="classifica.php">Classifica </a>
                <a href="profilo/profilo.php">Profilo </a>
                <a href="../logout/logout.php" class="logoutButton">Logout</a>
            </div>
        </div>
        
        <a href="../php/richieste.php" class="align-right">Richieste</a>
        <a id="contenitore-ricerca">
            <div class="barra_ricerca">
                <form>
                    <input type="text" id="cercaUtenti" placeholder="Cerca studenti..." autocomplete="off"/>
                    <button type="submit" id="pulsanteCercaUtenti"><i class="fa fa-search"></i></button>
                </form><br>
                <div id="listaUtenti">
                
                </div>
            </div>
        </a>
        <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="responsive()">&#9776;</a>
    </div>

    <div class="ricerca">
        <div class="ricerca_sinistra">
            <p>Cerca studenti</p>
            <form action="../php/queryStudenti.php" method="GET">
            <select id='listaMaterie' class='seleziona' name='materia' required data-dropup-auto="false">
                <?php print($materie); ?>
            </select>
            <select id='listaProvincie' class='seleziona' name='provincia' required data-dropup-auto="false">
                <?php print($provincie); ?>
            </select>
            <input type='submit' name='submit' class='cerca-pulsante'value='cerca' />
            </form>
        </div>
        <div class="ricerca_destra">
            <img src="../immagini/ricerca.svg">
        </div>
    </div>
    <div class="alert" id="ricNonCaricata"> 
        <strong>Ops!</strong> La richiesta non è stata caricata correttamente
    </div>
    <div class="alert success" id="ricCaricata">     
        <strong>Ottimo!</strong> La tua richiesta è stata caricata con successo
    </div>
    <div class="alert warning" id="ricEsistente"> 
        <strong>Attenzione!</strong> Hai già creato una richiesta con la stessa materia
    </div>
    <svg id="svgDiSopra" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#5656cf" fill-opacity="1" d="M0,128L48,144C96,160,192,192,288,186.7C384,181,480,139,576,144C672,149,768,203,864,224C960,245,1056,235,1152,197.3C1248,160,1344,96,1392,64L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
    </svg>
    <svg id="svgDiSotto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
        <path fill="#5656cf" fill-opacity="1" d="M0,128L48,144C96,160,192,192,288,186.7C384,181,480,139,576,144C672,149,768,203,864,224C960,245,1056,235,1152,197.3C1248,160,1344,96,1392,64L1440,32L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>   
    </svg>
    <div class='sezione-richieste'>
        <div class="richieste">
            
            <p id="ultime-richieste">Aggiungi una richiesta</p>
            <hr>
            <button id="pulsanteRecensione" class="pulsanteRecensione">Aggiungi</button>
            
                <div id="recensione" class="modal">

                    <div class="modal-content">
                        <form action="" method="POST">
                            <span id="chiudi" class="close">&times;</span>
                                <p id="scrittaValuta">Aggiungi richiesta</p>
                                <p id="spiegazione">Materia</p>
                                <select id='listaMaterieRichiesta' class='selezionaRichiesta' name='materia' required data-dropup-auto="false">
                                    <?php print($materie); ?>
                                </select>
                                <p id="spiegazione">Provincia<p>
                                <select id='listaProvince' class='selezionaRichiesta' name='provincia' required data-dropup-auto="false">
                                    <?php print($provincie); ?>
                                </select>
                                <p id="spiegazione">Descrizione</p>
                                    <textarea id="descrizioneRichiesta" name="descrizione" placeholder="Eventuali informazioni aggiuntive..."></textarea>
                                    <input type="button" class="pulsanteRecensione" id="richiesta" value="Aggiungi" name="valuta">
                        </form>
                    </div>

                </div>   
            
        </div>
        <div class='richiesta-immagine'>
            <img src='../immagini/aggiungiRichiesta.svg' />
        </div>
    </div>
    <footer class="footer-distributed">

			<div class="footer-right">

				<a href="#"><i class="fa fa-facebook"></i></a>
				<a href="#"><i class="fa fa-twitter"></i></a>
				<a href="#"><i class="fa fa-linkedin"></i></a>

			</div>

			<div class="footer-left">

				<p class="footer-links">
					<a class="link-1" href="../index.html">Home</a>

					<a href="../privacy/privacy.html">Privacy</a>

					<a href="../contact/contattaci.html">Contattaci</a>
				</p>

				<p>TUTORIFY &copy; 2020</p>
			</div>

	</footer>
    <script src="../js/responsive.js"></script>
    <script src="../js/ricercaUtenti.js"></script>
    <script src="../js/popupRichiesta.js"></script>
    <script src="../js/aggiungiRichiesta.js"></script>
</body>
</html>