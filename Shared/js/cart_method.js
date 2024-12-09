// Ventana flotante de confirmación de compra
function confirmPurchase() {
    const confirmation = confirm("¿Deseas realizar esta compra?");
    if (confirmation) {
        window.location.href = "confirmPurchase.php";
    }
}
