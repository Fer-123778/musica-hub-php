<?php
$titulo_pagina = "Noticias";
require_once 'includes/header.php';
require_once 'includes/nav.php';

$giras = [
    ['artista' => 'The Crimson Waves', 'ciudad' => 'Buenos Aires', 'fecha' => '12/12/2026'],
    ['artista' => 'Sofía Vega', 'ciudad' => 'Córdoba', 'fecha' => '19/12/2026'],
    ['artista' => 'Aurora Nights', 'ciudad' => 'Rosario', 'fecha' => '09/01/2027'],
];
?>

<main class="container py-5">
    <h1 class="mb-4">Noticias y giras</h1>
    <div class="row g-4">
        <?php foreach ($giras as $gira): ?>
            <div class="col-md-4">
                <div class="tarjeta">
                    <h2 class="h5"><?= $gira['artista']; ?></h2>
                    <p class="texto-suave mb-0"><?= $gira['ciudad']; ?> · <?= $gira['fecha']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>