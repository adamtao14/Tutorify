<?php
include("dbconnection.php");
$GLOBALS['dbConn'] = $db_connection;
/*
function controlloUploadImmagini($file)
{
    $errori="";
    $target_dir = "../uploads/";
    $fileName = time().basename($file["name"]);
    $fileName = str_replace(' ', '', $fileName);
    $target_file = $target_dir .$fileName;
    $_SESSION["nomeTemporaneoImmagine"] = $fileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($file["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $errori .= "-File non è un'immagine";
        $uploadOk = 0;
    }
    if ($file["size"] > 10000000) {
        $errori .= "-Grandezza file superiore ai 10 Mb ";
        $uploadOk = 0;
    }
    if (file_exists($target_file)) {
        $errori .= "Il file esiste già";
        $uploadOk = 0;
    }
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $errori .= "Il file può essere solo PNG,JPEG,JPG,GIF";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        $errori .= "Il file non è stato caricato,perfavore riprova";
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
        } else {
            $errori .= "Il file non è stato caricato,perfavore riprova";
        }
    }
    return $errori;

}*/
function controlloUploadImmagini($file)
{
    $errori="";
    $target_dir = "../uploads/";
    $fileName = time().basename($file["name"]);
    $fileName = str_replace(' ', '', $fileName);
    $target_file = $target_dir .$fileName;
    $_SESSION["nomeTemporaneoImmagine"] = $fileName;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($file["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $errori .= "-File non è un'immagine";
        $uploadOk = 0;
    }
    if ($file["size"] > 10000000) {
        $errori .= "-Grandezza file superiore ai 10 Mb ";
        $uploadOk = 0;
    }
    if (file_exists($target_file)) {
        $errori .= "Il file esiste già";
        $uploadOk = 0;
    }
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $errori .= "Il file può essere solo PNG,JPEG,JPG,GIF";
        $uploadOk = 0;
    }
    if ($uploadOk == 0) {
        $errori .= "Il file non è stato caricato,perfavore riprova";
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
        } else {
            $errori .= "Il file non è stato caricato,perfavore riprova";
        }
    }
    return $errori;

}

?>