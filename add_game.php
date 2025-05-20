<?php
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $genre = $_POST['genre'];
    $age_rating = $_POST['age_rating'];
    $price = $_POST['price'];
    $creator = $_POST['creator'];
    $size = $_POST['size'];
    $size_unit = $_POST['size_unit'];
    $image_filename = basename($_FILES["image"]["name"]);

    $target_dir = "uploads/";
    $target_file = $target_dir . $image_filename;

    
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $stmt = $conn->prepare("INSERT INTO jogos (name, genre, age_rating, price, creator, size, size_unit, image_filename) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssidsdss", $name, $genre, $age_rating, $price, $creator, $size, $size_unit, $image_filename);

        if ($stmt->execute()) {
            header("Location: manage_games.php");
        } else {
            echo "Erro ao cadastrar jogo: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Erro ao fazer upload da imagem.";
    }
}

$conn->close();
?>
