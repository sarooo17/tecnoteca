<?php
    require_once './db.php';
    
    $height = $_POST['height'];
    $articoli = array();

    $records_to_get = floor($height / 56);

    $sql = "SELECT prenotazioni.* FROM prenotazioni
            JOIN articoli ON prenotazioni.fk_articolo = articoli.id_articolo";

    if ($_SESSION['user_type'] == 'operatore') {
        $operator_centroid = $_SESSION['operator_centroid'];
        $sql .= " WHERE articoli.fk_centro = " . $operator_centroid;
    }

    $sql .= " LIMIT " . $records_to_get;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            
            $idprestito = $row['id_prenotazione'];
            $idutente = $row['fk_utente'];
            $idarticolo = $row['fk_articolo'];
            $stato = $row['stato'];

            $result2 = $conn->query("SELECT * FROM utenti WHERE id_utente = $idutente");
            $row2 = $result2->fetch_assoc(); 
            $email = $row2['email'];

            $result3 = $conn->query("SELECT * FROM articoli WHERE id_articolo = $idarticolo");
            $row3 = $result3->fetch_assoc();
            $articolo = $row3['nome'];

            $articolo_html = '<div class="box-data">';
            $articolo_html .= '<div class="articolo">';
            $articolo_html .= '<p><strong>' . $idprestito . '</strong></p>';
            $articolo_html .= '<p>' . $articolo . '</p>';
            $articolo_html .= '<p>' . $email . '</p>';

            if ($stato == "ritirato") {
                $articolo_html .= '<p class="disponibile">' . ucfirst($stato) . '</p>';
            } else if ($stato == "da ritirare") {
                $articolo_html .= '<p class="in-prestito">' . ucfirst($stato) . '</p>';
            }

            $articolo_html .= '</div></div><div class="line"></div>';

            $articoli[] = $articolo_html;
        }
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Nessuna prenotazione trovata']);
        exit();
    }

    echo json_encode($articoli);
?>