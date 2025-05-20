<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "game_store";
$port = 3307;

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
} else {
    echo "Conectado com sucesso!";
}
?>
