<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include "db_connect.php";

$user_id = $_SESSION['user_id'];
$game_id = $_POST['game_id'];


$user_check_query = $conn->prepare("SELECT id FROM usuarios WHERE id = ?");
$user_check_query->bind_param("i", $user_id);
$user_check_query->execute();
$user_check_query->store_result();

if ($user_check_query->num_rows == 0) {
    die("Usuário não encontrado.");
}


$game_check_query = $conn->prepare("SELECT id FROM jogos WHERE id = ?");
$game_check_query->bind_param("i", $game_id);
$game_check_query->execute();
$game_check_query->store_result();

if ($game_check_query->num_rows == 0) {
    die("Jogo não encontrado.");
}


$stmt = $conn->prepare("INSERT INTO cart (user_id, game_id) VALUES (?, ?)");
if (!$stmt) {
    die("Erro na preparação da consulta: " . $conn->error);
}


$stmt->bind_param("ii", $user_id, $game_id);


if ($stmt->execute()) {
    echo "Jogo adicionado ao carrinho com sucesso.";
    header("Location: store.php"); 
    exit();
} else {
    die("Erro ao adicionar ao carrinho: " . $stmt->error);
}


$stmt->close();
?>
