<?php
session_start();

// Eliminar todas las variables de sesión
$_SESSION = array();

// Si se desea destruir la sesión, también se puede hacer
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destruir la sesión
session_destroy();

// Redirigir a la página de inicio o de inicio de sesión
header("Location: index.php"); // Cambia esto a la página que desees
exit;
?>