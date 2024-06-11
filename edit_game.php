<?php
include('db_connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM jogos WHERE id = $id");
    $game = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $genre = $_POST['genre'];
    $age_rating = $_POST['age_rating'];
    $price = $_POST['price'];
    $creator = $_POST['creator'];
    $size = $_POST['size'];
    $size_unit = $_POST['size_unit'];
    $image_filename = $game['image_filename']; // Mantém o caminho atual da imagem

    if (isset($_FILES["image"]) && $_FILES["image"]["name"]) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_filename = basename($_FILES["image"]["name"]); // Atualiza o nome do arquivo da imagem
        }
    }

    $stmt = $conn->prepare("UPDATE jogos SET name=?, genre=?, age_rating=?, price=?, creator=?, size=?, size_unit=?, image_filename=? WHERE id=?");
    $stmt->bind_param("ssidsdssi", $name, $genre, $age_rating, $price, $creator, $size, $size_unit, $image_filename, $id);

    if ($stmt->execute()) {
        header("Location: manage_games.php");
    } else {
        echo "Erro ao atualizar jogo: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Jogo</title>
    <link rel="stylesheet" type="text/css" href="edit_game.css">
    <style>
        .scroll-container{
            max-height: 100vh;
            
        }
    </style>
</head>
<body>
<div class="scroll-container">   
<div class="form-container">
        <h2 class="h2h">Editar Jogo</h2>
        <form class="formulario" action="edit_game.php?id=<?php echo $game['id']; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $game['id']; ?>">
            
            <label for="name" class="TT" >Nome do Jogo:</label>
            <input type="text" id="name" name="name" value="<?php echo $game['name']; ?>" required>
            
            <label for="genre" class="TT">Gênero do Jogo:</label>
            <input type="text" id="genre" name="genre" value="<?php echo $game['genre']; ?>" required>
            
            <label for="age_rating" class="TT">Classificação de Idade:</label>
            <input type="number" id="age_rating" name="age_rating" value="<?php echo $game['age_rating']; ?>" required>
            
            <label for="price" class="TT">Preço:</label>
            <input type="number" step="0.01" id="price" name="price" value="<?php echo $game['price']; ?>" required>
            
            <label for="creator" class="TT">Criador:</label>
            <input type="text" id="creator" name="creator" value="<?php echo $game['creator']; ?>" required>
            
            <label for="size" class="TT">Tamanho do Jogo:</label>
            <input type="number" step="0.01" id="size" name="size" value="<?php echo $game['size']; ?>" required>
            <select id="size_unit" name="size_unit">
                <option value="MB" <?php echo $game['size_unit'] == 'MB' ? 'selected' : ''; ?>>MB</option>
                <option value="GB" <?php echo $game['size_unit'] == 'GB' ? 'selected' : ''; ?>>GB</option>
            </select>
            
            <label for="image" class="TT">Imagem Atual:</label>
            <img src="uploads/<?php echo $game['image_filename']; ?>" alt="<?php echo $game['name']; ?>" width="100"><br>
            
            <label for="image" class="TT">Nova Imagem (opcional):</label>
            <input type="file" id="image" name="image" accept="image/*">
            
            <button type="submit">Atualizar</button>
        </form>
    </div>
</div> 
</body>
</html>
