<?php
require_once "../Context/database.php";

class OrderService
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function createOrder($userId, $products)
    {
        $this->pdo->beginTransaction();

        try {
            $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, status) VALUES (?, 'pending')");
            $stmt->execute([$userId]);
            $orderId = $this->pdo->lastInsertId();

            foreach ($products as $product) {
                $stmt = $this->pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity) VALUES (?, ?, ?)");
                $stmt->execute([$orderId, $product['id'], $product['quantity']]);
            }

            $this->pdo->commit();
            return $orderId;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }

    public function getUserOrders($userId)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPendingOrders()
    {
        $stmt = $this->pdo->query("SELECT orders.*, users.username FROM orders 
                                   INNER JOIN users ON orders.user_id = users.id 
                                   WHERE orders.status = 'pending'");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrderStatus($orderId, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$status, $orderId]);
    }
}
?>
