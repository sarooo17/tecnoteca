<?php
    require_once './db.php';
    
    $height = $_POST['height'];
    $articoli = array();

    $records_to_get = floor($height / 56);

    $sql = "SELECT * FROM articoli";

    if ($_SESSION['user_type'] == 'operatore') {
        $operator_centroid = $_SESSION['operator_centroid'];
        $sql .= " WHERE fk_centro = " . $operator_centroid;
    }

    $sql .= " LIMIT " . $records_to_get;

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $numero_inventario = $row['numero_inventario'];
            $nome = $row['nome'];
            $centroid = $row['fk_centro'];
            $stato = $row['stato'];

            $sql_centro = "SELECT * FROM centri WHERE id_centro = $centroid";
            $result_centro = $conn->query($sql_centro);

            if ($result_centro->num_rows > 0) {
                while($row_centro = $result_centro->fetch_assoc()) {
                    $centro = $row_centro['nome'];
                }
            } else {
                $centro = "No center found";
            }

            $articolo_html = '<div class="box-data">';
            $articolo_html .= '<div class="articolo">';
            $articolo_html .= '<p><strong>' . $numero_inventario . '</strong></p>';
            $articolo_html .= '<p>' . ucfirst($nome) . '</p>';
            $articolo_html .= '<p>' . ucfirst($centro) . '</p>';

            if ($stato == "disponibile") {
                $articolo_html .= '<p class="disponibile">' . ucfirst($stato) . '</p>';
            } else if ($stato == "in prestito") {
                $articolo_html .= '<p class="in-prestito">' . ucfirst($stato) . '</p>';
            } else if ($stato == "guasto") {
                $articolo_html .= '<p class="guasto">' . ucfirst($stato) . '</p>';
            }

            $articolo_html .= '</div></div><div class="line"></div>';

            $articoli[] = $articolo_html;
        }
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Nessun articolo trovato']);
        exit();
    }
    echo json_encode($articoli);
?>