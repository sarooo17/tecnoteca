<?php

include("db.php");

$nome = $_POST['nome'];
$numero_inventario = $_POST['numero_inventario'];
$categoria = $_POST['categoria'];
$nome_centro = $_POST['nome_centro'];
$stato = $_POST['stato'];
$descrizione = $_POST['descrizione'];
$colore = $_POST['colore'];

$stmt = $conn->prepare("INSERT INTO articoli (nome, numero_inventario,fk_categoria,fk_centro, stato, descrizione, colore) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssiisss", $nome, $numero_inventario, $categoria, $nome_centro, $stato, $descrizione, $colore);

$stmt->execute();

if($conn->affected_rows > 0){
    header('Location: articoli-backend.php');
    exit;
}

$stmt->close();
$conn->close();
?>
