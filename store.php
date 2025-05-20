<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include "db_connect.php";
$sql = "SELECT * FROM jogos"; 
$query = $conn->query($sql);

if (!$query) {
    die("Erro na consulta ao banco de dados: " . $conn->error);
}

$num_rows = $query->num_rows;

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Loja de Jogos</title>
    <link rel="stylesheet" href="store.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<button type="button" onclick="window.location.href='index.php'">PAGINA INICIAL</button>
    <h1>Loja de Jogos</h1>
    <div class="games-container">
        <?php
        if ($num_rows > 0) {
            while ($row = $query->fetch_assoc()) {
                echo "<div class='game'>";
                echo "<img src='uploads/" . htmlspecialchars($row['image_filename']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
                echo "<h2>" . htmlspecialchars($row['name']) . "</h2>"; 
                echo "<p>Gênero: " . htmlspecialchars($row['genre']) . "</p>"; 
                echo "<p>Classificação: " . htmlspecialchars($row['age_rating']) . "</p>";
                echo "<p>Criador: " . htmlspecialchars($row['creator']) . "</p>";
                echo "<p>Tamanho: " . htmlspecialchars($row['size']) . " " . htmlspecialchars($row['size_unit']) . "</p>"; 
                echo "<p>Preço: R$" . htmlspecialchars($row['price']) . "</p>"; 
                echo "<form action='add_to_cart.php' method='post'>";
                echo "<input type='hidden' name='game_id' value='" . htmlspecialchars($row['id']) . "'>"; 
                echo "<button type='submit'>Adicionar ao Carrinho</button>";
                echo "</form>";
                echo "</div>";
            }
        } else {
            echo "<p>Nenhum jogo encontrado.</p>";
        }
        ?>
    </div>
</body>
</html>
