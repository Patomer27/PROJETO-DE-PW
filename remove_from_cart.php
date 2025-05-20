<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include "db_connect.php";

$user_id = $_SESSION['user_id'];
$game_id = $_POST['game_id'];

$stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND game_id = ?");
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}

$stmt->bind_param("ii", $user_id, $game_id);

if ($stmt->execute()) {
    echo "Jogo removido do carrinho com sucesso.";
    header("Location: cart.php"); 
    exit();
} else {
    die("Erro ao remover do carrinho: " . $stmt->error);
}

$stmt->close();
?>
