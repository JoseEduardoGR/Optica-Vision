<?php
require_once 'config/session.php';
require_once 'classes/User.php';

// Redirigir si ya está logueado
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $full_name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    // Validación
    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        $error = 'Por favor complete todos los campos obligatorios';
    } elseif ($password !== $confirm_password) {
        $error = 'Las contraseñas no coinciden';
    } elseif (strlen($password) < 6) {
        $error = 'La contraseña debe tener al menos 6 caracteres';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Por favor ingrese un email válido';
    } else {
        $user = new User();
        if ($user->register($username, $email, $password, $full_name, $phone)) {
            $success = '¡Registro exitoso! Ya puede iniciar sesión.';
        } else {
            $error = 'El usuario o email ya existe';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Óptica Visión</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <h1 class="login-title">👓 Registro</h1>
            
            <?php if ($error): ?>
                <div class="message message-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="message message-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username" class="form-label">Usuario *</label>
                    <input type="text" id="username" name="username" class="form-input" required 
                           value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                           placeholder="Nombre de usuario">
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" id="email" name="email" class="form-input" required 
                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"
                           placeholder="correo@ejemplo.com">
                </div>

                <div class="form-group">
                    <label for="full_name" class="form-label">Nombre Completo *</label>
                    <input type="text" id="full_name" name="full_name" class="form-input" required 
                           value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>"
                           placeholder="Su nombre completo">
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Teléfono</label>
                    <input type="tel" id="phone" name="phone" class="form-input" 
                           value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>"
                           placeholder="Número de teléfono">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Contraseña *</label>
                    <input type="password" id="password" name="password" class="form-input" required
                           placeholder="Mínimo 6 caracteres">
                </div>

                <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirmar Contraseña *</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-input" required
                           placeholder="Repita su contraseña">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Registrarse</button>
            </form>

            <div style="text-align: center; margin-top: 1.5rem;">
                <p>¿Ya tiene una cuenta? <a href="login.php" style="color: #6a4c93; font-weight: 500;">Inicie sesión aquí</a></p>
            </div>
        </div>
    </div>

    <script src="assets/js/script.js"></script>
</body>
</html>
