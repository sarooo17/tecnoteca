<?php
require_once './db.php';

$email = $_POST['email'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM utenti WHERE email = ? AND passmd5 = ?");
$stmt->bind_param('ss', $email, md5($password));

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    session_start();
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['id_utente'];
    $_SESSION['user_type'] = $row['tipologia_utente'];
    if ($row['tipologia_utente'] === 'cliente') {
        header('Location: ../index.php');
    } else{
        if ($_SESSION['user_type'] === 'operatore') {
            $_SESSION['operator_centroid'] = $row['fk_centro'];
        }
        header('Location: ./backend.php');
    }
} else {
    echo "User does not exist!";
}
?>