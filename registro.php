<?php
$titulo_pagina = "Registro";
require_once 'config/conexion.php';
require_once 'includes/auth_guard.php';

$nombre = '';
$email = '';
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmar = $_POST['confirmar'] ?? '';

    if (mb_strlen($nombre) < 2) {
        $errores[] = 'El nombre debe tener al menos 2 caracteres.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El formato del email no es válido.';
    }
    if (strlen($password) < 8) {
        $errores[] = 'La contraseña debe tener al menos 8 caracteres.';
    }
    if ($password !== $confirmar) {
        $errores[] = 'Las contraseñas no coinciden.';
    }

    if (empty($errores)) {
        $stmt = $pdo->prepare("SELECT id FROM usuarios WHERE email = :email");
        $stmt->execute([':email' => $email]);
        if ($stmt->fetch()) {
            $errores[] = 'Ese email ya está registrado.';
        }
    }

    if (empty($errores)) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO usuarios (nombre, email, password, id_rol)
                VALUES (:nombre, :email, :password,
                        (SELECT id FROM roles WHERE nombre = 'usuario'))";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':email' => $email,
            ':password' => $hash,
        ]);
        header('Location: login.php?registro=ok');
        exit;
    }
}

require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main class="container py-5" style="max-width: 560px;">
    <h1 class="mb-4">Crear cuenta</h1>

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
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?= h($nombre); ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= h($email); ?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña (mínimo 8 caracteres)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="confirmar" class="form-label">Repetir contraseña</label>
            <input type="password" class="form-control" id="confirmar" name="confirmar">
        </div>
        <button type="submit" class="btn btn-musica">Registrarme</button>
        <a href="login.php" class="btn btn-outline-light ms-2">Ya tengo cuenta</a>
    </form>
</main>

<?php require_once 'includes/footer.php'; ?>