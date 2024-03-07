<?php
session_start();
require_once './db.php';

if (isset($_FILES['img'])) {
    $file = $_FILES['img'];

    $fileName = $file['name'];
    $userID = $_SESSION['user_id']; 

    $uploadDir = '../img/users/';

    $sql = "SELECT img FROM utenti WHERE id_utente = $userID";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentImage = $row['img'];

        if (file_exists($uploadDir . $currentImage)) {
            unlink($uploadDir . $currentImage);
        }
    }

    $uploadFile = $uploadDir . basename($fileName);

    if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
        $sql = "UPDATE utenti SET img = '$fileName' WHERE id_utente = $userID";
        if ($conn->query($sql) === TRUE) {
            header('Location: ./user.php');
        } else {
            echo "Error updating profile image: " . $conn->error;
        }
    } else {
        echo "Si è verificato un errore durante il caricamento del file.";
    }
}else{
    echo "Nessun file selezionato.";
}
$conn->close();
?>