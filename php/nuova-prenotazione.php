<?php
require_once './db.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $idutente = $_SESSION['user_id'];
    $productId = $_POST['productId'];
    $dates = $_POST['datepickerButton'];

    list($startDate, $endDate) = explode(' - ', $dates);

    $sql = "INSERT INTO prenotazioni (fk_articolo, fk_utente, data_ritiro, data_restituzione) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $bindResult = $stmt->bind_param("iiss", $productId, $idutente, $startDate, $endDate);

    if ($bindResult === false) {
        die("Error binding the parameters: " . $stmt->error);
    }

    $executeResult = $stmt->execute();

    if ($executeResult === false) {
        die("Error executing the statement: " . $stmt->error);
    }

    header('Location: prestitiprenotazioni.php');
} else {
    header('Location: ../html/login.html');
}
?>