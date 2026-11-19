<?php
$titulo_pagina = "Géneros";
require_once 'includes/header.php';
require_once 'includes/nav.php';

$generos = ['Rock', 'Pop', 'Indie', 'Hip-Hop', 'Electrónica', 'Metal'];
?>

<main class="container py-5">
    <h1 class="mb-4">Géneros</h1>
    <?php
    $imagenes = [
        'Rock' => ['foto' => 'rock.jpg', 'id' => 'rock1'],
        'Pop' => ['foto' => 'pop.jpg', 'id' => 'pop1'],
        'Indie' => ['foto' => 'indie.jpg', 'id' => 'indie1'],
        'Hip-Hop' => ['foto' => 'hiphop.jpg', 'id' => 'hiphop1'],
        'Electrónica' => ['foto' => 'electronica.jpg', 'id' => 'electronica1'],
        'Metal' => ['foto' => 'metal.jpg', 'id' => 'metal1'],
    ];
    ?>
    <div class="row g-4">
        <?php foreach ($generos as $genero): ?>
            <div class="col-6 col-md-4">
                <a href="cancion.php?id=<?= $imagenes[$genero]['id']; ?>" class="text-decoration-none">
                    <div class="portada" style="background-image: linear-gradient(to top, rgba(10,10,20,0.85), rgba(10,10,20,0.1)), url('img/<?= $imagenes[$genero]['foto']; ?>');">
                        <?= $genero; ?>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</main>