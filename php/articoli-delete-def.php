<?php
    include("db.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST['id'];

        $sql = "DELETE FROM articoli_eliminati WHERE id_articolo = $id";

        if ($conn->query($sql) === TRUE) {
            header("Location: articoli-backend.php?filter=old");
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }

    $conn->close();
?>
