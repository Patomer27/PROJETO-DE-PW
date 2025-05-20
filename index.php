<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$url = "purchase_data.php";
$muda_texto = "Cadastrar Informaçoes";

include "db_connect.php";
$sql = "SELECT * FROM compras WHERE ID_USUARIO = " . $_SESSION["user_id"];
$query = $conn->query($sql);

if ($query->num_rows >= 1) {
    $url = "manage_purchases.php";
    $muda_texto = "Informações de Compra";
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Página Inicial</title>
    <link rel="stylesheet" href="index.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <img src="imagens negoçadas/horror-video-game.svg" alt="video game" width="500px" height="350px">
    <div class="container">
        <h2>Bem-vindo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <div class="links">
            <a href="manage_games.php">Gerenciar Jogos</a>
            <a href="add_game.html">Adicionar Jogos</a>
            <a href="<?php echo $url; ?>"><?php echo $muda_texto; ?></a>
            <a href="store.php">Loja</a>
            <a href="cart.php">Meu Carrinho</a>
            <a href="logout.php">Logout</a>
            <a href="AGRADECIMENTOS/AGRADECIMENTOS.html">Agradecimentos</a>
        </div>
    </div>
</body>
</html>