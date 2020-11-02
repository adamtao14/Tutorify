<?php
session_start();

include("funzioniQuery.php");

if(isset($_POST)){
    $idStudente = $_SESSION["id"];
    $Image = $_POST["immagine"];
    list($type, $Image) = explode(';', $Image);
    list(, $Image)      = explode(',', $Image);

    /** decoding del file in base64 **/
    $Image = base64_decode($Image);

    /* spostamento della nuova immagine in una cartella temporanea */
    $TempPath = '../temp/'.time().".jpg";
    file_put_contents($TempPath, $Image);

    $ImageSize = filesize($TempPath);/* grandezza file */

    if($ImageSize < 83889000){ /* limit size to 10 mb */

        /** spostamento della nuova immagine in uploads **/
        unlink($TempPath);
        $stringaRandom = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10);
        $nomeImmagine = time().$stringaRandom.".jpg";
        $path = '../uploads/'.$nomeImmagine;
        file_put_contents($path, $Image);
        
        $Image = $path;
        /** cancellazione vecchia immagine e caricamento di quella nuova **/
        $fotoProfiloPrecedente = ottieniFotoProfilo($idStudente);
        $esito = updateFotoProfilo($nomeImmagine, $idStudente);
        if(!$esito){
            print("error1");
        }else{
            if($fotoProfiloPrecedente != "" || $fotoProfiloPrecedente != null){
                unlink("../uploads/".$fotoProfiloPrecedente);
            }
            $_SESSION["immagine_profilo"] = "../".$path;
            print($nomeImmagine);
        }
        
        }else{
        
            unlink($TempPath);/* eliminazione file temporaneo */
        
            print("error2");
        
        }

    
}

/* VERSIONE VECCHIA DELLA GESTIONE DELLE IMMAGINI DI PROFILO */
/*
*
*
*
*/

/*
if ($file["error"] == 0) {
        $erroriImmagine = controlloUploadImmagini($file);
        if ($erroriImmagine != "") {
            if ($key == "immagine_banner") {
                $errori .= "<p class='erroreScritta'>L'immagine del banner non è stata caricata</p>";
                $errori = $errori . "\r\n" . $erroriImmagine;
            } else {
                $errori .= "<p class='erroreScritta'>L'immagine di profilo  non è stata caricata</p>";
                $errori = $errori . "\r\n" . $erroriImmagine;
            }
        } else {
            $nomeImmagine = $_SESSION["nomeTemporaneoImmagine"];
            if ($key != "immagine_banner") {
                $risultato = ottieniFotoProfilo($idStudente);
                if ($risultato != false) {
                    $path = "../uploads/" . $risultato;
                    unlink($path);
                }
                $esito = updateFotoProfilo($nomeImmagine, $idStudente);
                if (!$esito) {
                    $errori .= "<p class='erroreScritta'>L'immagine di profilo  non è stata caricata</p>";
                    $errori = $errori . "\r\n";
                } else {
                    $_SESSION["immagine_profilo"] = "../../uploads/" . $nomeImmagine;
                }
            } else {
                $risultato = ottieniBannerProfilo($idStudente);
                if ($risultato != false) {
                    $path = "../uploads/" . $risultato;
                    unlink($path);
                }
                $esito = updateFotoBanner($nomeImmagine, $idStudente);
                if (!$esito) {
                    $errori .= "<p class='erroreScritta'>L'immagine del banner non è stata caricata</p>";
                    $errori = $errori . "\r\n";
                } else {
                    $_SESSION["banner_profilo"] = "../../uploads/" . $nomeImmagine;
                }
            }
        }

    }

*/








?>