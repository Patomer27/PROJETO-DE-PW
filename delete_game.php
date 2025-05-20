<?php
include('db_connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $result = $conn->query("SELECT image_filename FROM jogos WHERE id = $id");
    $game = $result->fetch_assoc();
    $image_path = 'uploads/' . $game['image_filename'];
    if (file_exists($image_path)) {
        unlink($image_path);
    }

   
    $stmt = $conn->prepare("DELETE FROM cart WHERE game_id = ?");
    $stmt->bind_param("i", $id);
    if (!$stmt->execute()) {
        echo "Erro ao excluir registros dependentes: " . $stmt->error;
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();

   
    $stmt = $conn->prepare("DELETE FROM jogos WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        header("Location: manage_games.php");
    } else {
        echo "Erro ao excluir jogo: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
