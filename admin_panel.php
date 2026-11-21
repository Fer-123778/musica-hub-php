<?php
$titulo_pagina = "Panel de administración";
require_once 'config/conexion.php';
require_once 'includes/auth_guard.php';
requerir_rol('admin');

$total_usuarios = $pdo->query("SELECT COUNT(*) FROM usuarios")->fetchColumn();
$total_canciones = $pdo->query("SELECT COUNT(*) FROM canciones")->fetchColumn();

require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main class="container py-5">
    <h1 class="mb-4">Panel de administración</h1>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="tarjeta">
                <h2 class="h5">Usuarios</h2>
                <p class="display-6 mb-0"><?= h($total_usuarios); ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tarjeta">
                <h2 class="h5">Canciones</h2>
                <p class="display-6 mb-0"><?= h($total_canciones); ?></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tarjeta">
                <h2 class="h5">Gestión</h2>
                <a href="admin/index.php" class="btn btn-musica">Administrar canciones</a>
            </div>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>