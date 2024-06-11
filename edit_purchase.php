<?php
include('db_connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM compras WHERE id = $id");
    $purchase = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $cpf = $_POST['cpf'];
    $cep = $_POST['cep'];
    $cartao_credito = $_POST['cartao_credito'];
    $data_nascimento = $_POST['data_nascimento'];
    $nome_completo = $_POST['nome_completo'];
    $endereco = $_POST['endereco'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $telefone = $_POST['telefone'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE compras SET cpf=?, cep=?, cartao_credito=?, data_nascimento=?, nome_completo=?, endereco=?, cidade=?, estado=?, telefone=?, email=? WHERE id=?");
    $stmt->bind_param("ssssssssssi", $cpf, $cep, $cartao_credito, $data_nascimento, $nome_completo, $endereco, $cidade, $estado, $telefone, $email, $id);

    if ($stmt->execute()) {
        header("Location: manage_purchases.php");
    } else {
        echo "Erro ao atualizar dados de compra: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Dados de Compra</title>
    <link rel="stylesheet" href="edit_purchase.css">
    <style>
        .scroll-container {
            max-height: 100vh;
            
        }
    </style>
</head>
<body>
    <div class="scroll-container">
        <div class="form-container">
            <h2>Editar Dados de Compra</h2>
            <form action="edit_purchase.php?id=<?php echo $purchase['id']; ?>" method="POST">
                <input type="hidden" name="id" value="<?php echo $purchase['id']; ?>">

                <label for="cpf">CPF:</label>
                <input type="text" id="cpf" name="cpf" value="<?php echo $purchase['cpf']; ?>" required>

                <label for="cep">CEP:</label>
                <input type="text" id="cep" name="cep" value="<?php echo $purchase['cep']; ?>" required>

                <label for="cartao_credito">Cartão de Crédito:</label>
                <input type="text" id="cartao_credito" name="cartao_credito" value="<?php echo $purchase['cartao_credito']; ?>" required>

                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" value="<?php echo $purchase['data_nascimento']; ?>" required>

                <label for="nome_completo">Nome Completo:</label>
                <input type="text" id="nome_completo" name="nome_completo" value="<?php echo $purchase['nome_completo']; ?>" required>

                <label for="endereco">Endereço:</label>
                <input type="text" id="endereco" name="endereco" value="<?php echo $purchase['endereco']; ?>" required>

                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" value="<?php echo $purchase['cidade']; ?>" required>

                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" value="<?php echo $purchase['estado']; ?>" required maxlength="2">

                <label for="telefone">Telefone:</label>
                <input type="text" id="telefone" name="telefone" value="<?php echo $purchase['telefone']; ?>">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo $purchase['email']; ?>">

                <button type="submit">Atualizar</button>
            </form>
        </div>
    </div>
</body>
</html>
