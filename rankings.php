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
    <h1 class="mb-4">Rankings</h1>
    <p class="texto-suave">Las canciones más votadas por la comunidad.</p>
    <ol class="list-group list-group-numbered">
        <?php foreach ($canciones as $c): ?>
            <li class="list-group-item tarjeta d-flex justify-content-between mb-2">
                <span><?= $c['titulo']; ?> <span class="texto-suave">- <?= $c['artista']; ?></span></span>
                <span>⭐ <?= $c['votos']; ?></span>
            </li>
        <?php endforeach; ?>
    </ol>
</main>

<?php require_once 'includes/footer.php'; ?>