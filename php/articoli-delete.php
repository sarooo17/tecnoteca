<?php

include 'db.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $createTableQuery = "CREATE TABLE IF NOT EXISTS `articoli-eliminati` (
        id_articolo INT(11) PRIMARY KEY,
        numero_inventario VARCHAR(255),
        stato VARCHAR(255),
        fk_categoria INT(11),
        fk_centro INT(11),
        nome VARCHAR(255),
        colore VARCHAR(255),
        img VARCHAR(255),
        descrizione TEXT,
        deleted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->query($createTableQuery);

    $moveArticleQuery = "INSERT INTO `articoli-eliminati` (id_articolo, numero_inventario, stato, fk_categoria, fk_centro, nome, colore, img, descrizione)
        SELECT id_articolo, numero_inventario, stato, fk_categoria, fk_centro, nome, colore, img, descrizione FROM articoli WHERE id_articolo = $id";
    $conn->query($moveArticleQuery);

    $deleteArticleQuery = "DELETE FROM articoli WHERE id_articolo = $id";
    $conn->query($deleteArticleQuery);

    $conn->close();

    header('Location: articoli-backend.php');
} else {
    echo "Please provide the ID of the article to be deleted.";
}