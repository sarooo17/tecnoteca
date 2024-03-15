<?php
include 'db.php';

$id = $_GET['id'];

$stmt = $conn->prepare('SELECT id_articolo, numero_inventario, stato, fk_categoria, fk_centro, nome, colore, img, descrizione FROM articoli WHERE numero_inventario = ?');
$stmt->bind_param('i', $id);

$stmt->execute();

$stmt->bind_result($id_articolo,$numero_inventario, $stato, $fk_categoria, $fk_centro, $nome, $colore, $img, $descrizione);

$stmt->fetch();

$stmt->close(); // Chiudi il risultato corrente

$stmt = $conn->prepare('SELECT categoria, tipologia FROM categorie WHERE id_categoria = ?');
$stmt->bind_param('i', $fk_categoria);

$stmt->execute();

$stmt->bind_result($categoria, $tipologia);

$stmt->fetch();

$stmt->close(); // Chiudi il risultato corrente

$stmt = $conn->prepare('SELECT nome, via FROM centri WHERE id_centro = ?');
$stmt->bind_param('i', $fk_centro);

$stmt->execute();

$stmt->bind_result($nome_centro, $indirizzo);

$stmt->fetch();

$stmt->close(); // Chiudi il risultato corrente

$result = array(
    'id' => $id_articolo,
    'numero_inventario' => $numero_inventario,
    'stato' => $stato,
    'nome' => $nome,
    'colore' => $colore,
    'img' => $img,
    'descrizione' => $descrizione,
    'categoria' => $categoria,
    'tipologia' => $tipologia,
    'nome_centro' => $nome_centro,
    'indirizzo' => $indirizzo
);

echo json_encode($result);
?>