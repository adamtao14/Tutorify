<?php


// Questo file permette di cercare il proprio comune reperendolo dal database dalla tabella residenza


require("dbconnection.php");

if (isset($_POST["query"])) {

    $output = "";
    $query = "SELECT * FROM scuole WHERE '".$_POST["query"]."' LIKE CONCAT('%',nome,'%')";
    $stmt = $db_connection->query($query);
    if (!$stmt) {
        $query_controllo = "SELECT nome FROM scuole WHERE nome='" . $_POST["query"] . "'";
        $stmt_controllo = $db_connection->query($query);
        if ($stmt_controllo) {
            $rows_controllo = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($rows_controllo > 0) {
                $row_controllo = $rows_controllo[0];
                $output = "<li class='ElementoScuola'>" . $row_controllo["nome"] . "</li>";
            }

        } else {
            $output = "<li class='ElementoScuola'></li>";
        }

    } else {
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $output = "<ul>";
        if ($rows > 0) {
            foreach ($rows as $row) {
                $output .= "<li class='ElementoScuola'>" . $row["nome"] . "</li>";
            }
        } else {
            $output .= "<li class='ElementoScuola'></li>";
        }
    }
    $output .= "</ul>";
    echo $output;
}

?>