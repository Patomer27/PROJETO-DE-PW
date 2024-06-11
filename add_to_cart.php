<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['game_id'])) {
    include "db_connect.php";
    $game_id = intval($_POST['game_id']);
    $user_id = $_SESSION['user_id'];

    $sql = "INSERT INTO cart (user_id, game_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $game_id);

    if ($stmt->execute()) {
        echo "Jogo adicionado ao carrinho com sucesso.";
    } else {
        echo "Erro ao adicionar o jogo ao carrinho.";
    }

    $stmt->close();
    $conn->close();
}
header("Location: store.php");
exit();
?>
