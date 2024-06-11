<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include "db_connect.php";
$sql = "SELECT * FROM jogos"; // Usar a tabela 'jogos'
$query = $conn->query($sql);

// Depuração: Verifique se a consulta foi executada corretamente
if (!$query) {
    die("Erro na consulta ao banco de dados: " . $conn->error);
}

// Depuração: Exibir o número de linhas retornadas
$num_rows = $query->num_rows;
echo "Número de jogos encontrados: " . $num_rows;
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Loja de Jogos</title>
    <link rel="stylesheet" href="store.css"> <!-- Você pode criar um CSS específico para esta página -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <h1>Loja de Jogos</h1>
    <div class="games-container">
        <?php
        if ($num_rows > 0) {
            while ($row = $query->fetch_assoc()) {
                echo "<div class='game'>";
                echo "<img src='uploads/" . htmlspecialchars($row['image_filename']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
                echo "<h2>" . htmlspecialchars($row['name']) . "</h2>"; // Usando a coluna 'name' para o nome do jogo
                echo "<p>Gênero: " . htmlspecialchars($row['genre']) . "</p>"; // Exibir o gênero do jogo
                echo "<p>Classificação: " . htmlspecialchars($row['age_rating']) . "</p>"; // Exibir a classificação etária
                echo "<p>Criador: " . htmlspecialchars($row['creator']) . "</p>"; // Exibir o criador do jogo
                echo "<p>Tamanho: " . htmlspecialchars($row['size']) . " " . htmlspecialchars($row['size_unit']) . "</p>"; // Exibir o tamanho do jogo
                echo "<p>Preço: R$" . htmlspecialchars($row['price']) . "</p>"; // Exibir o preço do jogo
                echo "<form action='add_to_cart.php' method='post'>";
                echo "<input type='hidden' name='game_id' value='" . htmlspecialchars($row['id']) . "'>"; // Supondo que o ID esteja na coluna 'id'
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
