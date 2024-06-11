<?php
include('db_connect.php');
$result = $conn->query("SELECT * FROM jogos");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Jogos</title>
    <link rel="stylesheet" type="text/css" href="manage_games.css">
    <style>
        .scroll-container {
            max-height: 100vh;
            
        }
    </style>
</head>
<body>
<div class="scroll-container">  
<div class="container">
        <h2>Gerenciar Jogos</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Gênero</th>
                <th>Classificação de Idade</th>
                <th>Preço</th>
                <th>Criador</th>
                <th>Tamanho</th>
                <th>Imagem</th>
                <th>Ações</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['genre']; ?></td>
                <td><?php echo $row['age_rating']; ?></td>
                <td><?php echo $row['price']; ?></td>
                <td><?php echo $row['creator']; ?></td>
                <td><?php echo $row['size'] . ' ' . $row['size_unit']; ?></td>
                <td><img src="uploads/<?php echo $row['image_filename']; ?>" alt="<?php echo $row['name']; ?>" width="100"></td>
                <td>
                    <a href="edit_game.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="delete_game.php?id=<?php echo $row['id']; ?>">Excluir</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="index.php" class="return-link">Voltar à Página Inicial</a>
    </div>
</div> 
</body>
</html>

<?php $conn->close(); ?>
