<?php
session_start();
include("../php/funzioniQuery.php");
settaClassifica();
//ottengo la classifica attuale
$risultato = ottieniClassifica();
//creazione della tabella
$tabella = "";
if(count($risultato) > 0){
    $tabella .= 
    "
    <table>
        <thead>
            <th>#</th>
            <th></th>
            <th>Nome</th>
            <th>Cognome</th>
            <th>Media</th>
            <th>Numero recensioni</th>
        </thead>
    ";
    for($i = 0; $i < count($risultato); $i++){
        $urlImmagine = "";
        if($risultato[$i]["immagine_profilo"] == ""){
            $urlImmagine = "profilo/immagini_default/default_profilo.jpg";
        }else{
            $urlImmagine = "../uploads/".$risultato[$i]["immagine_profilo"];
        }
        $tabella .=
        "
        <tr>
            <td>".($i+1)."</td>
            <td><img src='".$urlImmagine."'/></td>
            <td>".$risultato[$i]["nome"]."</td>
            <td>".$risultato[$i]["cognome"]."</td>
            <td>".$risultato[$i]["mediaValutazioni"]."</td>
            <td>".$risultato[$i]["numeroRecensioni"]."</td>
        </tr>
        ";
    }
    $tabella .= "</table>";
}else{
    $tabella = "<h1 id='disclaimer'>La classifica è temporaneamente non disponibile</h1>";
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/navbar.css">
    <link rel="stylesheet" href="../css/footer.css">
    <link rel="stylesheet" href="../css/classifica.css">
    <link rel='shortcut icon' href='../immagini/favicon.ico'/>
    <link rel='shortcut icon' href='http://tutorify.it/immagini/favicon.ico'/>
    <script src='//code.jquery.com/jquery-1.10.2.js'></script>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Classifica Tutorify</title>
</head>
<body>
    <div class="navbar" id="navbar">
        <a href="dashboard.php" class="active align-left" id="logo">TUTORIFY</a>
        
        <div class="dropdown">
            <button class="dropbtn"><?php print($_SESSION["nome"]); ?> 
            &#9662;
            </button>
            <div class="dropdown-content">
                <a href="#">Classifica </a>
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
    <?php print($tabella) ?>
    

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