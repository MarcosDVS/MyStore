<?php
session_start();
require_once "../Context/database.php";
require_once "../Service/cartService.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
} // Si no se ha iniciado sesion te redigira al login

$cartService = new CartService();

$user = $_SESSION['user'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $cartService->addToCart($productId, 1);
    header("Location: cart.php");
    exit();
}

$userId = $user['id'];
$cartItems = $cartService->getCartItems($userId);
?>

<?php require_once "../Shared/header.php"; ?>

<h2>Carrito de Compras</h2>
<table class="table">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cartItems as $item): ?>
            <tr>
                <td><?= $item['name'] ?></td>
                <td><?= $item['quantity'] ?></td>
                <td>$<?= $item['price'] ?></td>
                <td>$<?= $item['quantity'] * $item['price'] ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<button onclick="confirmPurchase()" class="btn btn-success">Realizar Compra</button>


<script src="../Shared/js/cart_method.js"></script>
<?php require_once "../Shared/footer.php"; ?>
