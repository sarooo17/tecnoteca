<?php
header('Content-Type: application/json');

include 'db.php';
$productId = $_POST['productId'];

$stmt = $conn->prepare('SELECT data_ritiro, data_restituzione FROM prenotazioni WHERE fk_articolo = ?');
$stmt->bind_param('s', $productId);
$stmt->execute();

$result = $stmt->get_result();
$prenotazioni = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($prenotazioni);
?>