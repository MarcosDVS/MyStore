<?php
session_start();
require_once "../Context/database.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user']['id'];

// Obtener pedidos del usuario
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ?");
$stmt->execute([$userId]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once "../Shared/header.php"; ?>

<div class="container mt-5">
    <h2>Mis Pedidos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID Pedido</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= $order['id'] ?></td>
                    <td><?= $order['status'] ?></td>
                    <td><?= $order['created_at'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once "../Shared/footer.php"; ?>
