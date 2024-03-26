<?php
include 'db.php';
if(isset($_POST['id'])) {
    $id_prenotazione = $_POST['id'];

    $query = "DELETE FROM prenotazioni WHERE id_prenotazione = ?";

    $stmt = $conn->prepare($query);

    $stmt->bind_param("i", $id_prenotazione);

    if($stmt->execute()) {
        header('Location: prestitiprenotazioni.php');
    } else {
        echo "Error occurred while deleting the row.";
    }

    $stmt->close();
} else {
    echo "id_prenotazione not provided.";
}

$conn->close();
?>