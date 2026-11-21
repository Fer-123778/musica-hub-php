<?php
$titulo_pagina = "Mi panel";
require_once 'config/conexion.php';
require_once 'includes/auth_guard.php';
requerir_login();

require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main class="container py-5">
    <h1 class="mb-3">Hola, <?= h($_SESSION['usuario_nombre']); ?></h1>
    <p class="texto-suave">Tu rol es: <strong><?= h($_SESSION['rol']); ?></strong></p>

    <div class="row g-4 mt-2">
        <div class="col-md-6">
            <div class="tarjeta">
                <h2 class="h5">Mi cuenta</h2>
                <p class="texto-suave">Estás autenticado con una sesión segura.</p>
                <a href="logout.php" class="btn btn-outline-light">Cerrar sesión</a>
            </div>
        </div>
        <?php if ($_SESSION['rol'] === 'admin'): ?>
            <div class="col-md-6">
                <div class="tarjeta">
                    <h2 class="h5">Administración</h2>
                    <p class="texto-suave">Como administrador, podés entrar al panel de control.</p>
                    <a href="admin_panel.php" class="btn btn-musica">Ir al panel de administración</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>