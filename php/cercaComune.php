<?php


// Questo file permette di cercare il proprio comune reperendolo dal database dalla tabella residenza


require("dbconnection.php");

if (isset($_POST["query"])) {

    $output = "";
    $query = "SELECT nome_comune FROM comuni WHERE nome_comune LIKE '" . $_POST["query"] . "%'";
    $stmt = $db_connection->query($query);
    if (!$stmt) {
        $query_controllo = "SELECT nome_comune FROM comuni WHERE nome_comune='" . $_POST["query"] . "'";
        $stmt_controllo = $db_connection->query($query);
        if ($stmt_controllo) {
            $rows_controllo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows_controllo > 0) {
                $row_controllo = $rows_controllo[0];
                $output = "<li class='ElementoComune'>" . $row_controllo["nome_comune"] . "</li>";
            }

        } else {
            $output = "<li class='ElementoComune'>Comune non trovato</li>";
        }

    } else {
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $output = "<ul>";
        if ($rows > 0) {
            foreach ($rows as $row) {
                $output .= "<li class='ElementoComune'>" . $row["nome_comune"] . "</li>";
            }
        } else {
            $output .= "<li class='ElementoComune'>Comune non trovato</li>";
        }
    }
    $output .= "</ul>";
    echo $output;
}

?>