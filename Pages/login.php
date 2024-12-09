<?php
require_once "../Context/database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user'] = $user;
            header("Location: index.php");
            exit();
        } else {
            $error = "Credenciales incorrectas.";
        }
    } elseif (isset($_POST['register'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $role = 'user';

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $password, $role]);

        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Autenticación - EL BRONCO TECH</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="../Shared/js/logingMethod.js">  
    </script>
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow" style="width: 400px;">
            <div class="card-body">
                <h2 class="text-center text-primary"><i class="fas fa-user-lock"></i> Autenticación</h2>
                
                <!-- Formulario de Login -->
                <form id="loginForm" method="POST" class="mb-3">
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label fw-bold">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-success btn-block">Iniciar Sesión</button>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger mt-3"><?= $error ?></div>
                    <?php endif; ?>
                </form>

                <!-- Formulario de Registro -->
                <form id="registerForm" method="POST" class="mb-3 d-none">
                    <div class="mb-3">
                        <label for="username" class="form-label fw-bold">Nombre de Usuario</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold">Correo Electrónico</label>
                        <input type="email" class="form-control" id="emailRegister" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="passwordRegister" class="form-label fw-bold">Contraseña</label>
                        <input type="password" class="form-control" id="passwordRegister" name="password" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary btn-block">Registrarse</button>
                </form>

                <div class="text-center">
                    <button class="btn btn-link" id="toggleToRegister" onclick="toggleForms()" style="display: none;">¿No tienes cuenta? Regístrate aquí</button>
                    <button class="btn btn-link" id="toggleToLogin" onclick="toggleForms()" style="display: none;">¿Ya tienes cuenta? Inicia sesión aquí</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
