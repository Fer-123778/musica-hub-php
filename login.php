<?php
$titulo_pagina = "Iniciar sesión";
require_once 'config/conexion.php';
require_once 'includes/auth_guard.php';

if (isset($_SESSION['usuario_id'])) {
    header('Location: panel.php');
    exit;
}

$email = '';
$errores = [];
$aviso = '';

if (($_GET['error'] ?? '') === 'acceso_denegado') {
    $aviso = 'Tenés que iniciar sesión para ver esa página.';
} elseif (($_GET['error'] ?? '') === 'sin_permiso') {
    $aviso = 'No tenés permisos para ver esa página.';
} elseif (($_GET['registro'] ?? '') === 'ok') {
    $aviso = 'Cuenta creada. Ya podés iniciar sesión.';
} elseif (($_GET['logout'] ?? '') === 'ok') {
    $aviso = 'Cerraste sesión correctamente.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $errores[] = 'Completá el email y la contraseña.';
    } else {
        $sql = "SELECT u.id, u.nombre, u.password, r.nombre AS rol
                FROM usuarios u
                INNER JOIN roles r ON u.id_rol = r.id
                WHERE u.email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $usuario = $stmt->fetch();

        if ($usuario && password_verify($password, $usuario['password'])) {
            session_regenerate_id(true);
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];
            header('Location: panel.php');
            exit;
        }
        $errores[] = 'Email o contraseña incorrectos.';
    }
}

require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main class="container py-5" style="max-width: 560px;">
    <h1 class="mb-4">Iniciar sesión</h1>

    <?php if ($aviso !== ''): ?>
        <div class="alert alert-info" role="alert"><?= h($aviso); ?></div>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                <?php foreach ($errores as $error): ?>
                    <li><?= h($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" class="tarjeta" data-bs-theme="dark">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= h($email); ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-musica">Entrar</button>
        <a href="registro.php" class="btn btn-outline-light ms-2">Crear cuenta</a>
    </form>
</main>

<?php require_once 'includes/footer.php'; ?>