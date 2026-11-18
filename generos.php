<?php
$titulo_pagina = "Géneros";
require_once 'includes/header.php';
require_once 'includes/nav.php';

$generos = ['Rock', 'Pop', 'Indie', 'Hip-Hop', 'Electrónica', 'Metal'];
?>

<main class="container py-5">
    <h1 class="mb-4">Géneros</h1>
    <div class="row g-4">
        <?php foreach ($generos as $genero): ?>
            <div class="col-6 col-md-4">
                <div class="tarjeta text-center">
                    <h2 class="h5 mb-0"><?= $genero; ?></h2>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>