<?php
    require_once './db.php';
    
    $height = $_POST['height'];
    $articoli = array();

    $records_to_get = floor($height / 56);

    $result = $conn->query("SELECT * FROM utenti LIMIT $records_to_get");

    while ($row = $result->fetch_assoc()) {
        $nome = $row['nome'];
        $cognome = $row['cognome'];
        $email = $row['email'];
        $tipo = $row['tipologia_utente'];

        $articolo_html = '<div class="box-data">';
        $articolo_html .= '<div class="articolo">';
        $articolo_html .= '<p><strong>' . ucfirst($nome) . '</strong></p>';
        $articolo_html .= '<p>' . ucfirst($cognome) . '</p>';
        $articolo_html .= '<p>' . $email . '</p>';

        if ($tipo == "cliente") {
            $articolo_html .= '<p class="disponibile">' . ucfirst($tipo) . '</p>';
        } else if ($tipo == "admin") {
            $articolo_html .= '<p class="in-prestito">' . ucfirst($tipo) . '</p>';
        } else if ($tipo == "operatore") {
            $articolo_html .= '<p class="guasto">' . ucfirst($tipo) . '</p>';
        }

        $articolo_html .= '</div></div><div class="line"></div>';

        $articoli[] = $articolo_html;
    }

    echo json_encode($articoli);
?>