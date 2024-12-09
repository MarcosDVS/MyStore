<?php
class CartService
{
    public function addToCart($productId, $quantity)
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $quantity = (int)$quantity;

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    public function removeFromCart($productId)
    {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    public function getCartItems($userId)
    {
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            return [];
        }

        // Filtrar los artículos del carrito según el user_id
        $filteredItems = [];
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            // Aquí asumo que tienes una función para obtener el user_id del producto
            // Debes implementar la lógica para obtener el user_id del producto
            $productUserId = $this->getProductUserId($productId); // Método ficticio
            if ($productUserId === $userId) {
                $filteredItems[$productId] = $quantity;
            }
        }

        return $filteredItems;
    }

    // Método ficticio para obtener el user_id del producto
    private function getProductUserId($productId)
    {
        // Implementa la lógica para obtener el user_id del producto desde la base de datos
        // Por ejemplo, podrías hacer una consulta a la base de datos aquí
    }

    public function clearCart()
    {
        $_SESSION['cart'] = [];
    }
}
?>
