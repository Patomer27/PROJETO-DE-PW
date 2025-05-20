<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

include "db_connect.php";

$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare("
    SELECT jogos.id, jogos.name, jogos.price, jogos.image_filename
    FROM cart
    INNER JOIN jogos ON cart.game_id = jogos.id
    WHERE cart.user_id = ?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Meu Carrinho</title>
    <link rel="stylesheet" type="text/css" href="cart.css">
</head>
<body>
<button type="button" onclick="window.location.href='index.php'">PAGINA INICIAL</button>
    <h1>Meu Carrinho</h1>
    <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Preço</th>
                <th>Ação</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="uploads/<?php echo htmlspecialchars($row['image_filename']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" width="100"></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td>R$ <?php echo htmlspecialchars($row['price']); ?></td>
                    <td>
                        <form action="remove_from_cart.php" method="post">
                            <input type="hidden" name="game_id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            <button type="submit">Remover</button>
                            
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <h1>Seu carrinho está vazio!!</h1>
    <?php endif; ?>
</body>
</html>
<?php
$stmt->close();
?>
