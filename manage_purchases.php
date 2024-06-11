<?php
session_start();
include('db_connect.php');

$result = $conn->query("SELECT * FROM compras WHERE ID_USUARIO = ".$_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gerenciar Compras</title>
    <link rel="stylesheet" type="text/css" href="manage_purchases.css">
</head>
<body>
    <div class="container">
        <h2>Gerenciar Compras</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>CPF</th>
                <th>CEP</th>
                <th>Cartão de Crédito</th>
                <th>Data de Nascimento</th>
                <th>Nome Completo</th>
                <th>Endereço</th>
                <th>Cidade</th>
                <th>Estado</th>
                <th>Telefone</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['cpf']; ?></td>
                <td><?php echo $row['cep']; ?></td>
                <td><?php echo $row['cartao_credito']; ?></td>
                <td><?php echo $row['data_nascimento']; ?></td>
                <td><?php echo $row['nome_completo']; ?></td>
                <td><?php echo $row['endereco']; ?></td>
                <td><?php echo $row['cidade']; ?></td>
                <td><?php echo $row['estado']; ?></td>
                <td><?php echo $row['telefone']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>
                    <a href="edit_purchase.php?id=<?php echo $row['id']; ?>">Editar</a>
                </td>
            </tr>
            <?php } ?>
        </table><br>

        <a href="index.php" ><button type="submit" class="tela_inicial">Voltar a tela Inicial</button></a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
