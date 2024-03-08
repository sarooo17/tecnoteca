<?php
require_once './db.php';

$name = $_POST['name'];
$surname = $_POST['surname'];
$email = $_POST['email'];
$password = md5($_POST['password']);
$confirm_password = md5($_POST['password_confirm']);
$address = $_POST['address'];
$city = $_POST['city'];
$cap = $_POST['cap'];
$province = $_POST['province'];
$stato = $_POST['stato'];

$sql = "SELECT id_città FROM città WHERE nome = '$city' AND cap = '$cap'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $city_id = $row['id_città'];
} else {
    $sql = "INSERT INTO città (nome, cap, provincia, stato) VALUES ('$city', '$cap', '$province', '$stato')";
    if ($conn->query($sql) === TRUE) {
        $city_id = $conn->insert_id;
    } else {
        echo "Errore durante l'inserimento della città nel database: " . $conn->error;
        $conn->close();
        exit();
    }
}

if ($password !== $confirm_password) {
    echo "Le password non corrispondono";
    $conn->close();
    exit();
}

$sql = "INSERT INTO utenti (nome, cognome, email, passmd5, indirizzo, fk_città, tipologia_utente)
        VALUES ('$name', '$surname', '$email', '$password', '$address', '$city_id', 'cliente')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../index.php");
} else {
    echo "Errore durante l'inserimento dei dati nel database: " . $conn->error;
}

$conn->close();
?>