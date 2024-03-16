<?php
include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $moveArticleQuery = "INSERT INTO `articoli` (id_articolo, numero_inventario, stato, fk_categoria, fk_centro, nome, colore, img, descrizione)
        SELECT id_articolo, numero_inventario, 'disponibile', fk_categoria, fk_centro, nome, colore, img, descrizione FROM articoli_eliminati WHERE id_articolo = $id";
    $conn->query($moveArticleQuery);

    $deleteArticleQuery = "DELETE FROM articoli_eliminati WHERE id_articolo = $id";
    $conn->query($deleteArticleQuery);


    header("Location: articoli-backend.php");
    $conn->close();
}

?>
