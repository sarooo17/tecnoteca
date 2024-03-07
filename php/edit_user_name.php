<?php
session_start();
require_once('./db.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method.";
    exit;
}

$userID = $_SESSION['user_id'];

$newName = $_POST['nome'];
$newSurname = $_POST['cognome'];

$query = "UPDATE utenti SET nome = ?, cognome = ? WHERE id_utente = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $newName, $newSurname, $userID);
$result = $stmt->execute();

if ($result) {
    header('Location: ./user.php');
} else {
    echo "Failed to update user name and surname.";
}

?>