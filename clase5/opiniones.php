<?php
$titulo_pagina = "Opiniones";
$base = '../';
require_once 'datos.php';
require_once '../includes/header.php';
require_once '../includes/nav.php';

$nombre = '';
$email = '';
$mensaje = '';
$errores = [];
$exito = false;
$nombre_gracias = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre  = trim($_POST['nombre'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $mensaje = trim($_POST['mensaje'] ?? '');

    if (empty($nombre)) {
        $errores[] = 'El nombre es obligatorio.';
    } elseif (mb_strlen($nombre) < 2) {
        $errores[] = 'El nombre debe tener al menos 2 caracteres.';
    }

    if (empty($email)) {
        $errores[] = 'El email es obligatorio.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El formato del email no es válido.';
    }

    if (empty($mensaje)) {
        $errores[] = 'La opinión es obligatoria.';
    } elseif (mb_strlen($mensaje) < 10) {
        $errores[] = 'La opinión debe tener al menos 10 caracteres.';
    }

    if (empty($errores)) {
        $exito = true;
        $nombre_gracias = limpiar($nombre);
        $nombre = '';
        $email = '';
        $mensaje = '';
    }
}
?>

<main class="container py-5" style="max-width: 720px;">
    <h1 class="mb-2">Dejá tu opinión</h1>
    <p class="texto-suave mb-4">Contanos qué te parece <?= APP_NAME; ?>.</p>

    <?php if ($exito): ?>
        <div class="alert alert-success" role="alert">
            ¡Gracias, <?= $nombre_gracias; ?>! Tu opinión se envió correctamente.
        </div>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger" role="alert">
            <p class="mb-2 fw-semibold">Revisá los siguientes errores:</p>
            <ul class="mb-0">
                <?php foreach ($errores as $error): ?>
                    <li><?= $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="opiniones.php" novalidate class="tarjeta" data-bs-theme="dark">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre"
                   value="<?= limpiar($nombre); ?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email"
                   value="<?= limpiar($email); ?>">
        </div>
        <div class="mb-3">
            <label for="mensaje" class="form-label">Tu opinión</label>
            <textarea class="form-control" id="mensaje" name="mensaje" rows="5"><?= limpiar($mensaje); ?></textarea>
        </div>
        <button type="submit" class="btn btn-musica">Enviar opinión</button>
    </form>
</main>

<?php require_once '../includes/footer.php'; ?>