<?php
$titulo_pagina = "Rankings";
require_once 'includes/header.php';
require_once 'includes/nav.php';

$canciones = [
    ['titulo' => 'Verano Infinito', 'artista' => 'Coral City', 'votos' => 3200],
    ['titulo' => 'Mountain Rain', 'artista' => 'Elara Stone', 'votos' => 1400],
    ['titulo' => 'Luz de Costa', 'artista' => 'Coral City', 'votos' => 2400],
    ['titulo' => 'Void Walker', 'artista' => 'Black Atlas', 'votos' => 560],
];
?>

<main class="container py-5">
    <h1 class="mb-2">Rankings</h1>
    <p class="texto-suave mb-4">Las canciones más votadas por la comunidad.</p>
    <?php foreach ($canciones as $i => $c): ?>
        <div class="fila-ranking">
            <span class="numero"><?= $i + 1; ?></span>
            <div>
                <div class="fw-semibold"><?= $c['titulo']; ?></div>
                <div class="texto-suave small"><?= $c['artista']; ?></div>
            </div>
            <span class="votos">⭐ <?= number_format($c['votos'], 0, ',', '.'); ?></span>
        </div>
    <?php endforeach; ?>
</main>