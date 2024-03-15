<?php
include 'db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $numero_inventario = $_POST['numero_inventario'];
    $categoria = $_POST['categoria'];
    $nome_centro = $_POST['nome_centro'];
    $stato = $_POST['stato'];
    $descrizione = $_POST['descrizione'];
    $colore = $_POST['colore'];
    $tipologia = $_POST['tipologia'];
    $indirizzo = $_POST['indirizzo'];

    $query = "UPDATE articoli SET nome = '$nome', numero_inventario = '$numero_inventario', stato = '$stato', descrizione = '$descrizione', colore = '$colore' WHERE id_articolo = $id";

    $query = $conn->query($query);

    if ($query) {
        header('Location: articoli-backend.php');
    } else {
        echo "Update failed";
    }
}
?>