<?php
session_start();
require_once('./db.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method.";
    exit;
}

$userID = $_SESSION['user_id'];

$oldPassword = $_POST['old-password'];
$newPassword = $_POST['new-password'];
$confirmPassword = $_POST['conf-password'];

$query = "SELECT passmd5 FROM utenti WHERE id_utente = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentPassword = $row['passmd5'];

    if (md5($oldPassword) === $currentPassword) {
        if ($newPassword === $confirmPassword) {
            $newPassword = md5($newPassword);
            $query = "UPDATE utenti SET passmd5 = ? WHERE id_utente = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $newPassword, $userID);
            $result = $stmt->execute();
        } else {
            echo "Le nuove password non corrispondono.";
            exit;
        }
    } else {
        echo "La vecchia password non è corretta.";
        exit;
    }
}

if ($result) {
    header('Location: ./user.php');
}

?>