<?php
session_start();
require_once('./db.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method.";
    exit;
}

$userID = $_SESSION['user_id'];

$newIndirizzo = $_POST['indirizzo'];

$query = "UPDATE utenti SET indirizzo = ? WHERE id_utente = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $newIndirizzo, $userID);
$result = $stmt->execute();

if ($result) {
    header('Location: ./user.php');
}

?>