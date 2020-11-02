<?php

include("dbconnection.php");
$GLOBALS['dbConn'] = $db_connection;
function esistenzaEmail($email)
{

    $sql = "SELECT ID FROM studenti WHERE email=:email";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (sizeof($rows) > 0) {
        return true;
    } else {
        return false;
    }
}
function esistenzaTelefono($telefono)
{

    $sql = "SELECT ID FROM studenti WHERE telefono=:telefono";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (sizeof($rows) > 0) {
        return true;
    } else {
        return false;
    }
}
function cercaIdResidenza($residenza)
{
    $sql = 'SELECT ID FROM comuni WHERE nome_comune=:residenza';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':residenza', $residenza);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row = $rows[0];
    return $row["ID"];
}
function cercaIdProvinciaConComune($residenza)
{
    $sql = 'SELECT id_provincia FROM comuni WHERE nome_comune=:residenza';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':residenza', $residenza);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row = $rows[0];
    return $row["id_provincia"];
}
function caricaScuola($scuola)
{
    $sql = 'INSERT INTO scuole(nome) VALUES(:scuola)';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':scuola', $scuola);
    $stmt->execute();
}

function caricaDati($nome, $cognome, $email, $passwordCriptata, $dataNascita, $id_residenza, $ruolo, $verificato, $profilo_completato, $token)
{

    $sql = "INSERT INTO studenti(nome,cognome,email,password,data_nascita,residenza,ruolo,verificato,profilo_completato,token) VALUES (:nome,:cognome,:email,:password,:data_nascita,:residenza,:ruolo,:verificato,:profilo_completato,:token)";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cognome', $cognome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $passwordCriptata);
    $stmt->bindParam(':data_nascita', $dataNascita);
    $stmt->bindParam(':residenza', $id_residenza);
    $stmt->bindParam(':ruolo', $ruolo);
    $stmt->bindParam(':verificato', $verificato);
    $stmt->bindParam(':profilo_completato', $profilo_completato);
    $stmt->bindParam(':token', $token);
    $risultatoInsert = $stmt->execute();
    return $risultatoInsert;
}

function confermaUtente($tokenDaVerificare, $emailDaVerificare)
{

    $sql = 'SELECT ID FROM studenti WHERE token=:token AND email=:email LIMIT 1';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':token', $tokenDaVerificare);
    $stmt->bindParam(':email', $emailDaVerificare);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (sizeof($rows) > 0) {
        return true;
    } else {
        return false;
    }
}
function aggiungiRecensione($idStudenteRecensito, $idStudenteRecensore, $valutazione, $descrizione, $data)
{

    $sql = 'INSERT INTO recensioni(fk_id_studente_recensito,fk_id_scrittore_recensione,descrizione,data,valutazione) VALUES(:idStudenteRecensito,:idStudenteRecensore,:descrizione,:data,:valutazione)';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idStudenteRecensito', $idStudenteRecensito);
    $stmt->bindParam(':idStudenteRecensore', $idStudenteRecensore);
    $stmt->bindParam(':valutazione', $valutazione);
    $stmt->bindParam(':descrizione', $descrizione);
    $stmt->bindParam(':data', $data);
    $esito = $stmt->execute();
    if ($esito) {
        return true;
    } else {
        return false;
    }
}
function verificaUtente($emailDaVerificare)
{

    $sql = 'UPDATE studenti SET verificato=1 WHERE email="' . $emailDaVerificare . '"';
    $stmt = $GLOBALS['dbConn']->query($sql);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function cancellaUtenteInFaseDiRegistrazione($email)
{
    $sql = 'DELETE FROM studenti WHERE email=:email';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
}

function ottieniScuole($scuolaStudente)
{
    $sql = 'SELECT nome FROM scuole';
    $stmt = $GLOBALS['dbConn']->query($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $risultato = '';
    if ($scuolaStudente != "") {
        foreach ($rows as $row) {
            if ($row["nome"] == $scuolaStudente) {
                $risultato .= '<option value="' . $row["nome"] . '" selected>' . $row["nome"] . '</option>';
            } else {
                $risultato .= '<option value="' . $row["nome"] . '">' . $row["nome"] . '</option>';
            }
        }
    } else {
        foreach ($rows as $row) {
            $risultato .= '<option value="' . $row["nome"] . '" selected>' . $row["nome"] . '</option>';
        }
    }

    return $risultato;
}
function ottieniProvincia($idProvincia){
    $sql = 'SELECT nome_provincia FROM province WHERE ID=:idProvincia';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idProvincia', $idProvincia);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row = $rows[0];
    return $row["nome_provincia"];
}
function ottieniPasswordCriptataUtente($id){
    $sql = 'SELECT password FROM studenti WHERE ID=:idUtente';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idUtente', $id);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row = $rows[0];
    return $row["password"];
}
function ottieniClassi($classeStudente)
{
    $sql = 'SELECT num_classe FROM classi';
    $stmt = $GLOBALS['dbConn']->query($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $risultato = '';
    if ($classeStudente != "") {
        foreach ($rows as $row) {
            if ($row["num_classe"] == $classeStudente) {
                $risultato .= '<option value="' . $row["num_classe"] . '" selected>' . $row["num_classe"] . '</option>';
            } else {
                $risultato .= '<option value="' . $row["num_classe"] . '">' . $row["num_classe"] . '</option>';
            }
        }
    } else {
        foreach ($rows as $row) {
            $risultato .= '<option value="' . $row["num_classe"] . '" selected>' . $row["num_classe"] . '</option>';
        }
    }

    return $risultato;
}
function ottieniIndirizzi($indirizzoStudente)
{
    $sql = 'SELECT nome_indirizzo FROM indirizzi_scolastici';
    $stmt = $GLOBALS['dbConn']->query($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $risultato = '';
    if ($indirizzoStudente != "") {
        foreach ($rows as $row) {
            if ($row["nome_indirizzo"] == $indirizzoStudente) {
                $risultato .= '<option value="' . $row["nome_indirizzo"] . '" selected>' . $row["nome_indirizzo"] . '</option>';
            } else {
                $risultato .= '<option value="' . $row["nome_indirizzo"] . '">' . $row["nome_indirizzo"] . '</option>';
            }
        }
    } else {
        foreach ($rows as $row) {
            $risultato .= '<option value="' . $row["nome_indirizzo"] . '" selected>' . $row["nome_indirizzo"] . '</option>';
        }
    }
    return $risultato;
}
function ottieniMaterie()
{
    $sql = 'SELECT descrizione FROM materie ORDER BY descrizione ASC';
    $stmt = $GLOBALS['dbConn']->query($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $risultato = '';
    foreach ($rows as $row) {
        $risultato .= '<option value="' . $row["descrizione"] . '">'.$row["descrizione"].'</option><br>';

    }
    return $risultato;
}
function ottieniProvincie()
{
    $sql = 'SELECT nome_provincia FROM province ORDER BY nome_provincia ASC';
    $stmt = $GLOBALS['dbConn']->query($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $risultato = '';
    $sql = 'SELECT nome_provincia FROM province,comuni WHERE comuni.id_provincia = province.ID AND comuni.nome_comune =:comune';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':comune', $_SESSION["comune"]);
    $stmt->execute();
    $provinciaUtente = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($rows as $row) {
        if ($row["nome_provincia"] == $provinciaUtente[0]["nome_provincia"]) {
            $risultato .= '<option selected value="' . $row["nome_provincia"] . '">' . $row["nome_provincia"] . '</option>';
        } else {
            $risultato .= '<option value="' . $row["nome_provincia"] . '">' . $row["nome_provincia"] . '</option>';
        }


    }
    return $risultato;
}
function cercaIdScuola($scuolaScelta)
{
    $sql = 'SELECT ID FROM scuole WHERE nome="' . $scuolaScelta . '"';
    $stmt = $GLOBALS['dbConn']->query($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($rows) > 0) {
        $row = $rows[0];
        return $row["ID"];
    } else {
        return null;
    }

}
function ottieniClassifica(){
    $sql = 'SELECT studenti.nome,studenti.cognome,studenti.immagine_profilo,AVG(recensioni.valutazione) AS mediaValutazioni,COUNT(recensioni.fk_id_studente_recensito) AS numeroRecensioni FROM recensioni,studenti WHERE recensioni.fk_id_studente_recensito = studenti.ID GROUP BY studenti.nome ORDER BY `mediaValutazioni` DESC,numeroRecensioni DESC LIMIT 10';
    $stmt = $GLOBALS['dbConn']->query($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function cercaIdClasse($classeScelta)
{
    $sql = 'SELECT ID FROM classi WHERE num_classe=:num_classe';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':num_classe', $classeScelta);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row = $rows[0];
    return $row["ID"];
}
function cercaIdIndirizzoScelto($indirizzoScelto)
{
    $sql = 'SELECT ID FROM indirizzi_scolastici WHERE nome_indirizzo="' . $indirizzoScelto . '"';
    $stmt = $GLOBALS['dbConn']->query($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row = $rows[0];
    return $row["ID"];
}
function cercaIdMateriaScelta($MateriaScelta)
{
    $sql = 'SELECT ID FROM materie WHERE descrizione="' . $MateriaScelta . '"';
    $stmt = $GLOBALS['dbConn']->query($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row = $rows[0];
    return $row["ID"];
}
function updateFotoProfilo($nomeImmagine, $id)
{
    $sql = 'UPDATE studenti SET immagine_profilo=:nomeImmagine WHERE ID=:id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':nomeImmagine', $nomeImmagine);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function updateNumero($telefono,$id){
    $sql = 'UPDATE studenti SET telefono=:telefono WHERE ID=:id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}


function updateFotoBanner($nomeImmagine, $id)
{
    $sql = 'UPDATE studenti SET banner_profilo=:nomeImmagine WHERE ID=:id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':nomeImmagine', $nomeImmagine);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function updateScuola($idScuola, $idStudente)
{
    $sql = 'UPDATE studenti SET scuola=:idScuola WHERE ID=:id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idScuola', $idScuola);
    $stmt->bindParam(':id', $idStudente);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function updateDescrizione($descrizione, $idStudente)
{
    $sql = 'UPDATE studenti SET descrizione=:descrizione WHERE ID=:id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':descrizione', $descrizione);
    $stmt->bindParam(':id', $idStudente);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function updateClasse($idClasse, $idStudente)
{
    $sql = 'UPDATE studenti SET classe=:idClasse WHERE ID=:id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idClasse', $idClasse);
    $stmt->bindParam(':id', $idStudente);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function updateIndirizzo($idIndirizzo, $idStudente)
{
    $sql = 'UPDATE studenti SET indirizzo=:indirizzo WHERE ID=:id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':indirizzo', $idIndirizzo);
    $stmt->bindParam(':id', $idStudente);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function updateComune($idResidenza, $id)
{
    $sql = 'UPDATE studenti SET residenza=:residenza WHERE ID=:id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':residenza', $idResidenza);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function updateNomeCognome($nome, $cognome, $id)
{
    $sql = 'UPDATE studenti SET nome="' . $nome . '",cognome="' . $cognome . '" WHERE ID="' . $id . '"';
    $stmt = $GLOBALS['dbConn']->query($sql);
    if ($stmt->execute()) {
        return $sql;
    } else {
        return false;
    }
}
function updateDataNascita($dataNascita, $id)
{
    $sql = "UPDATE studenti SET data_nascita=:dataNascita WHERE studenti.ID=:id";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':dataNascita', $dataNascita);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function aggiungiMateriaStudente($idMateriaScelta, $idStudente)
{
    $sql = "INSERT INTO materie_studenti(fk_id_studente,fk_id_materia) VALUES (:fk_id_studente,:fk_id_materia)";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':fk_id_studente', $idStudente);
    $stmt->bindParam(':fk_id_materia', $idMateriaScelta);
    $risultatoInsert = $stmt->execute();
    return $risultatoInsert;
}
function aggiungiContatto($nome, $email, $descrizione, $data)
{
    $sql = "INSERT INTO contatti(nome,email,descrizione,data) VALUES (:nome,:email,:descrizione,:data)";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':descrizione', $descrizione);
    $stmt->bindParam(':data', $data);
    $risultatoInsert = $stmt->execute();
    return $risultatoInsert;
}
function profiloCompletato($idDaCompletare)
{
    $sql = 'UPDATE studenti SET profilo_completato=1 WHERE id=' . $idDaCompletare . '';
    $stmt = $GLOBALS['dbConn']->query($sql);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function creaToken()
{
    $token = bin2hex(random_bytes(50));
    return $token;
}
function ottieniRichiesteStudente($id){
    $sql = 'SELECT richieste.ID,richieste.descrizione AS descrizioneRichiesta,data,materie.descrizione AS descrizioneMateria FROM materie,richieste WHERE richieste.fk_id_studente = :id AND materie.ID = richieste.fk_id_materia ORDER BY data DESC';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function aggiungiRecordPasswordDimenticata($email, $token, $orarioCorrente)
{
    $sql = "INSERT INTO password_dimenticata(email,token,orario) VALUES (:email,:token,:orarioCorrente)";
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':token', $token);
    $stmt->bindParam(':orarioCorrente', $orarioCorrente);
    $risultatoInsert = $stmt->execute();
    return $risultatoInsert;
}
function validitaTokenResetPassword($email, $token)
{
    $sql = 'SELECT orario FROM password_dimenticata WHERE email=:email AND token=:token';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row = $rows[0];
    $orarioCorrente = time();
    if (($orarioCorrente - $row["orario"]) < 1800) {
        return true;
    } else {
        return false;
    }
}
function modificaPassword($password, $email)
{
    $sql = 'UPDATE studenti SET password=:password WHERE email=:email';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':email', $email);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function eliminaRecordPasswordDimenticata($email, $token)
{
    $sql = 'DELETE FROM password_dimenticata WHERE email=:email AND token=:token';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':token', $token);
    $stmt->execute();
}
function ottieniDatiStudente($id)
{
    $sql = 'SELECT studenti.email,studenti.immagine_profilo,studenti.banner_profilo,studenti.telefono,studenti.nome,studenti.cognome,comuni.nome_comune,classi.num_classe,indirizzi_scolastici.nome_indirizzo,studenti.descrizione ,studenti.data_nascita FROM studenti,classi,comuni,indirizzi_scolastici,scuole WHERE studenti.id=:id AND studenti.scuola=scuole.id AND classi.id=studenti.classe AND indirizzi_scolastici.id=studenti.indirizzo AND studenti.residenza=comuni.ID';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function settaClassifica(){
    $sql = 'set session sql_mode=""';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}
function ottieniImmaginiUtente($id){
    $sql = 'SELECT studenti.immagine_profilo,studenti.banner_profilo FROM studenti WHERE studenti.ID = :id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows[0];
}
function ottieniNumeroTelefono($id)
{
    $sql = 'SELECT studenti.telefono FROM studenti WHERE studenti.ID = :id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows[0]["telefono"];
}
function calcolaEta($dataNascita)
{
    if (!empty($dataNascita)) {
        $data = new DateTime($dataNascita);
        $oggi = new DateTime('today');
        $eta = $data->diff($oggi)->y;
        return $eta;
    } else {
        return 0;
    }
}
function ottieniStudenteScuola($id)
{
    $sql = 'SELECT scuole.nome FROM studenti,scuole WHERE studenti.id=:id AND studenti.scuola=scuole.id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}

function ottieniMaterieStudenti($id)
{
    $sql = 'SELECT materie.descrizione FROM materie,materie_studenti WHERE materie_studenti.fk_id_studente=:id AND materie_studenti.fk_id_materia = materie.id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $materie = "";
    $i = 0;
    if (sizeof($rows) != 0) {
        foreach ($rows as $row) {
            if ($i + 1 == sizeof($rows)) {
                $materie .= $row["descrizione"];
            } else {
                $materie .= $row["descrizione"] . "-";
            }
            $i++;
        }
    }
    return $materie;
}
function controlloEsistenzaRecensione($idStudenteRecensito,$idStudenteRecensore){
    $sql = 'SELECT ID FROM recensioni WHERE fk_id_studente_recensito = :idStudenteRecensito AND fk_id_scrittore_recensione = :idStudenteRecensore';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idStudenteRecensito', $idStudenteRecensito);
    $stmt->bindParam(':idStudenteRecensore', $idStudenteRecensore);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(count($rows) > 0){
        return true;
    }else{
        return false;
    }
}
function controlloEsistenzaRichiesta($idStudente,$idMateria,$descrizione,$idProvincia){
    $sql = 'SELECT ID FROM richieste WHERE fk_id_studente = :idStudente AND fk_id_materia = :fk_id_materia AND fk_id_provincia = :fk_id_provincia';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idStudente', $idStudente);
    $stmt->bindParam(':fk_id_materia', $idMateria);
    $stmt->bindParam(':fk_id_provincia', $idProvincia);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(count($rows) > 0){
        return true;
    }else{
        return false;
    }
}
function aggiungiRichiesta($idStudente,$idMateria,$descrizione,$idProvincia,$data){
    $sql = 'INSERT INTO richieste(fk_id_studente,descrizione,data,fk_id_materia,fk_id_provincia) VALUES(:idStudente,:descrizione,:data,:fk_id_materia,:fk_id_provincia)';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idStudente', $idStudente);
    $stmt->bindParam(':descrizione', $descrizione);
    $stmt->bindParam(':data', $data);
    $stmt->bindParam(':fk_id_materia', $idMateria);
    $stmt->bindParam(':fk_id_provincia', $idProvincia);
    $esito = $stmt->execute();
    return $esito;
}
function ottieniIdMateria($materia)
{
    $sql = 'SELECT materie.ID FROM materie WHERE materie.descrizione=:materia';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':materia', $materia);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $row = $rows[0];
    return $row["ID"];
}
function ottieniIdProvincia($comune)
{
    $sql = 'SELECT province.ID FROM province WHERE nome_provincia=:provincia';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':provincia', $comune);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if(count($rows) > 0){
        $row = $rows[0];
        return $row["ID"];
    }
    
}
function ottieniRecensioni($idStudente){
    $sql = 'SELECT recensioni.ID,recensioni.fk_id_scrittore_recensione,recensioni.descrizione,recensioni.data,recensioni.valutazione,studenti.nome,studenti.cognome,studenti.immagine_profilo FROM recensioni,studenti WHERE recensioni.fk_id_studente_recensito=:idStudente AND studenti.ID = recensioni.fk_id_scrittore_recensione ORDER BY recensioni.data DESC';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idStudente', $idStudente);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}
function ottieniFotoProfilo($id)
{
    $sql = 'SELECT immagine_profilo FROM studenti WHERE ID=:id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($rows) > 0) {
        return $rows[0]["immagine_profilo"];
    } else {
        return false;
    }
}
function ottieniBannerProfilo($id)
{
    $sql = 'SELECT banner_profilo FROM studenti WHERE ID=:id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($rows) > 0) {
        return $rows[0]["banner_profilo"];
    } else {
        return false;
    }
}
function eliminaUtente($id){
    $sql = 'DELETE FROM studenti WHERE ID = :id';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':id', $id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function eliminaMateriaStudente($idStudente, $idMateria)
{
    $sql = 'DELETE FROM materie_studenti WHERE materie_studenti.fk_id_studente=:idStudente AND materie_studenti.fk_id_materia=:idMateria';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idStudente', $idStudente);
    $stmt->bindParam(':idMateria', $idMateria);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function eliminaRichiestaStudente($idStudente, $idRichiesta)
{
    $sql = 'DELETE FROM richieste WHERE richieste.fk_id_studente=:idStudente AND richieste.ID=:idRichiesta';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idStudente', $idStudente);
    $stmt->bindParam(':idRichiesta', $idRichiesta);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function eliminaRecensioni($idRecensione){
    $sql = 'DELETE FROM recensioni WHERE ID=:idRecensione';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idRecensione', $idRecensione);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
function esistenzaMateriaUtente($idStudente, $idMateria)
{
    $sql = 'SELECT materie_studenti.ID FROM materie_studenti WHERE materie_studenti.fk_id_studente=:idStudente AND materie_studenti.fk_id_materia=:idMateria';
    $stmt = $GLOBALS['dbConn']->prepare($sql);
    $stmt->bindParam(':idStudente', $idStudente);
    $stmt->bindParam(':idMateria', $idMateria);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (count($rows) > 0) {
        return true;
    } else {
        return false;
    }
}



?>