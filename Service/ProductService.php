<?php
require_once "../Context/database.php";

class ProductService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllProducts()
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addProduct($name, $description, $price)
    {
        $stmt = $this->pdo->prepare("INSERT INTO products (name, description, price) VALUES (?, ?, ?)");
        $stmt->execute([$name, $description, $price]);
        return $this->pdo->lastInsertId();
    }

    public function addProductImage($productId, $imagePath)
    {
        $stmt = $this->pdo->prepare("INSERT INTO product_images (product_id, image_path) VALUES (?, ?)");
        $stmt->execute([$productId, $imagePath]);
    }

    public function deleteProduct($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
