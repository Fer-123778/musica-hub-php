<?php
$titulo_pagina = "Contacto";
require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main class="container py-5">
    <h1 class="mb-4">Contacto</h1>
    <p class="texto-suave">Escribinos a <a href="mailto:<?= APP_EMAIL; ?>"><?= APP_EMAIL; ?></a></p>
    <div class="tarjeta">
        <p class="mb-1"><strong><?= APP_NAME; ?></strong></p>
        <p class="texto-suave mb-0">Entorno de ejecución: <?= APP_ENV; ?></p>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>