<?php
require_once 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idprestito = $_POST['id'];

    $sql = "UPDATE prestiti SET stato = 'restituito', data_restituzione = CURDATE() WHERE id_prestito = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $idprestito);
    $stmt->execute();


    if ($conn->affected_rows > 0) {
        header("Location: prestiti-backend.php");
        exit();
    } else {
        echo "Failed to update status.";
    }
}
?>