<?php
include 'db.php';

$id = $_POST['id'];

$stmt = $conn->prepare('SELECT `id_utente`, `nome`, `cognome`, `indirizzo`, `fk_città`, `email`, `tipologia_utente`, `img` FROM utenti WHERE id_utente = ?');
$stmt->bind_param('i', $id);

$stmt->execute();

$stmt->bind_result($id_utente,$nome, $stato, $cognome, $indirizzo, $fk_città, $email, $tipologia_utente ,$img);

$stmt->fetch();

$stmt->close(); // Chiudi il risultato corrente

$stmt = $conn->prepare('SELECT nome, cap, provincia, stato FROM città WHERE città = ?');
$stmt->bind_param('i', $fk_città);

$stmt->execute();

$stmt->bind_result($nome_città, $cap, $provincia, $stato);

$stmt->fetch();

$stmt->close();

$result = array(
    'id' => $id_articolo,
    'nome' => $nome,
    'cognome' => $cognome,
    'indirizzo' => $indirizzo,
    'città' => $nome_città,
    'cap' => $cap,
    'provincia' => $provincia,
    'stato' => $stato,
    'email' => $email,
    'tipologia' => $tipologia_utente,
    'img' => $img
);

echo json_encode($result);
?>