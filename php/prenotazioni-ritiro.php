<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $reservationId = $_POST['id'];
        
        $sql = "SELECT * FROM prenotazioni WHERE id_prenotazione = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $reservationId);
        $stmt->execute();

        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productId = $row['fk_articolo'];
                $idPrenotazione = $row['id_prenotazione'];
                $dataRitiro = $row['data_ritiro'];
                $dataRestituzione = $row['data_restituzione'];
                $idutente = $row['fk_utente'];

                $sqlnewprestito = "INSERT INTO prestiti (fk_articolo, fk_utente, data_inizio_prestito, data_scadenza_prestito, stato) VALUES (?, ?, ?, ?, 'in prestito')";
                $stmtnewprestito = $conn->prepare($sqlnewprestito);
                $stmtnewprestito->bind_param('iiss', $productId, $idutente, $dataRitiro, $dataRestituzione);
                $stmtnewprestito->execute();

                $sqlupdate = "UPDATE prenotazioni SET stato = 'ritirato' WHERE id_prenotazione = ?";
                $stmtupdate = $conn->prepare($sqlupdate);
                $stmtupdate->bind_param('i', $reservationId);
                $stmtupdate->execute();
            }

            header("Location: prenotazioni-backend.php");
        } else {
            http_response_code(404);
            echo 'Reservation not found';
            exit();
        }

    } else {
        http_response_code(400);
        echo 'Missing parameter: id';
    }
}
?>