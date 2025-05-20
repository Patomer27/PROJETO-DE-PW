<?php
include('db_connect.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cpf = $_POST['cpf'];
    $cep = $_POST['cep'];
    $cartao_credito = $_POST['cartao_credito'];
    $data_nascimento = $_POST['data_nascimento'];
    $nome_completo = $_POST['nome_completo'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $telefone = isset($_POST['telefone']) ? $_POST['telefone'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;


    $stmt = $conn->prepare("INSERT INTO compras (cpf, cep, cartao_credito, data_nascimento, nome_completo, endereco, cidade, estado, telefone, email, ID_USUARIO) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssi", $cpf, $cep, $cartao_credito, $data_nascimento, $nome_completo, $endereco, $cidade, $estado, $telefone, $email, $_SESSION["user_id"]); 

    if ($stmt->execute()) {
        echo "<h1>Dados de compra salvos com sucesso!</h1>";
    } else {
        echo "<h1>Erro ao salvar dados de compra</h1> " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html>
<head>
    <title>Dados de Compra</title>
    <link rel="stylesheet" type="text/css" href="purchase_data.css">
</head>
<body>
    <div class="form-container">
        <h2>Dados de Compra</h2>
        <form action="purchase_data.php" method="POST">
            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" required>
            
            <label for="cep">CEP:</label>
            <input type="text" id="cep" name="cep" required>
            
            <label for="cartao_credito">Cartão de Crédito:</label>
            <input type="text" id="cartao_credito" name="cartao_credito" required>
            
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required>
            
            <label for="nome_completo">Nome Completo:</label>
            <input type="text" id="nome_completo" name="nome_completo" required>
            
            <label for="endereco">Endereço:</label>
            <input type="text" id="endereco" name="endereco" required>
            
            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade" required>
            
            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado" required maxlength="2">
            
            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone">
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email">
            
            <button type="submit">Enviar</button><br><br>
            
        </form>
        <button type="button" onclick="window.location.href='index.php'" class="button-link">PAGINA INICIAL</button>
        </div>
</body>
</html>
