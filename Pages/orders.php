<?php
// Verificar si la sesión ya está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../Context/database.php";

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Obtener pedidos pendientes
$stmt = $pdo->query("SELECT orders.id, users.username, orders.status 
    FROM orders 
    INNER JOIN users ON orders.user_id = users.id 
    WHERE orders.status = 'pending'");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Confirmar pedido
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $orderId = $_POST['order_id'];
    $stmt = $pdo->prepare("UPDATE orders SET status = 'in_progress' WHERE id = ?");
    $stmt->execute([$orderId]);

    header("Location: orders.php");
    exit();
}
?>

<?php require_once "../Shared/header.php"; ?>

<div class="container mt-5">
    <h2>Gestión de Pedidos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['username'] ?></td>
                    <td><?= $order['status'] ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                            <button type="submit" class="btn btn-success">Confirmar Pedido</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once "../Shared/footer.php"; ?>
