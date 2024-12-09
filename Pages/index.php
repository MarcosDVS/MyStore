<?php
require_once "../Context/database.php";
require_once "../Shared/header.php";
// require_once "../Shared/navMenu.php";

// Obtener productos de la base de datos
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<h1 class="text-center">Bienvenido a EL BRONCO TECH</h1>
<div class="row">
    <?php foreach ($products as $product): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="../Shared/img/<?= $product['id'] ?>.jpg" class="card-img-top" alt="<?= $product['name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $product['name'] ?></h5>
                    <p class="card-text"><?= $product['description'] ?></p>
                    <p class="card-text"><strong>Precio:</strong> $<?= number_format($product['price'], 2) ?></p>
                    <form action="cart.php" method="post" onsubmit="return confirmQuantity()" class="mb-3">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <div class="input-group">
                            <input type="number" id="quantity" name="quantity" min="1" value="1" required class="form-control">
                            <button type="submit" class="btn btn-primary">Agregar al carrito</button>
                        </div>
                    </form>

                    <script>
                        function confirmQuantity() {
                            const quantity = document.getElementById('quantity').value;
                            return confirm(`¿Deseas agregar ${quantity} unidades de este producto al carrito?`);
                        }
                    </script>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php require_once "../Shared/footer.php"; ?>
