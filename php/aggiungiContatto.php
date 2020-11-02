<?php

include("funzioniQuery.php");
if(isset($_POST)){
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $messaggio = $_POST["messaggio"];
    $data = date("Y-m-d h:i:sa");
    $risultato = '';
    $esito = aggiungiContatto($nome,$email,$messaggio,$data);
    if($esito == 1){
        $risultato = 
        '
        <div class="contenitore">
            <h2>Grazie per averci contattato</h2>
            <img src="../immagini/contattoRicevuto.svg" />
            <p>Ti risponderemo il prima possibile</p>
            <a href="../index.html">Torna in home</a>
        </div>
        ';
    }else{
        $risultato = 
        '
        <div class="contenitore">
            <h2>Qualcosa è andato storto</h2>
            <img src="../immagini/cancella.svg" />
            <p>Perfavore riprova a contattarci</p>
            <a href="../index.html">Torna in home</a>
        </div>
        ';
    }
    $html =
    '
        <html lang="en">
            <head>
            <meta content="width=device-width, initial-scale=1" name="viewport" />
            <link rel="stylesheet" href="../css/aggiungiContatto.css" />
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            <title>VERIFICA EMAIL</title>
            <meta charset="UTF-8" >
            
            </head>
            
            <body>
            '.$risultato.'
            </body>
        </html>
    ';
    print($html);
    
}



?>