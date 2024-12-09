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

// Agregar producto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $images = $_FILES['images'];

    // Insertar producto
    $stmt = $pdo->prepare("INSERT INTO products (name, description, price) VALUES (?, ?, ?)");
    $stmt->execute([$name, $description, $price]);
    $productId = $pdo->lastInsertId();

    // Guardar imágenes
    foreach ($images['tmp_name'] as $key => $tmpName) {
        $destination = "../Shared/img/{$productId}_{$key}.jpg";
        move_uploaded_file($tmpName, $destination);
    }

    header("Location: addProduct.php");
    exit();
}

// Obtener productos
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php require_once "../Shared/header.php"; ?>
<?php require_once "../Shared/navMenu.php"; ?>

<div class="container mt-5">
    <h2>Panel de Administración</h2>

    <!-- Botón para abrir el modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
        Agregar Nuevo Producto
    </button>

    <!-- Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Agregar Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del Producto</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Precio</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="images" class="form-label">Imágenes</label>
                            <input type="file" class="form-control" id="images" name="images[]" multiple required>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Producto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-4">Lista de Productos</h3>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= $product['name'] ?></td>
                    <td><?= $product['description'] ?></td>
                    <td>$<?= number_format($product['price'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php require_once "../Shared/footer.php"; ?>
