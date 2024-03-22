<?php
include 'db.php';
$productId = $_POST['productId'];

$stmt = $conn->prepare('SELECT data_prenotazione, fine_prestito FROM prenotazioni WHERE fk_articolo = ?');
$stmt->bind_param('s', $productId);
$stmt->execute();

$prenotazioni = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($prenotazioni);
?>