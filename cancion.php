<?php
$canciones = [
    'pop1' => ['titulo' => 'Barcelona', 'artista' => 'vibemode', 'genero' => 'Pop', 'portada' => 'pop.jpg'],
    'pop2' => ['titulo' => 'Pop Music', 'artista' => 'prettyjohn1', 'genero' => 'Pop', 'portada' => 'pop.jpg'],
    'rock1' => ['titulo' => 'Rock Music', 'artista' => 'jonasblakewood', 'genero' => 'Rock', 'portada' => 'rock.jpg'],
    'rock2' => ['titulo' => 'Dirty Rock', 'artista' => 'kulakovka', 'genero' => 'Rock', 'portada' => 'rock.jpg'],
    'indie1' => ['titulo' => 'Summer Walk', 'artista' => 'folk_acoustic', 'genero' => 'Indie', 'portada' => 'indie.jpg'],
    'indie2' => ['titulo' => 'Indie Folk', 'artista' => 'jonasblakewood', 'genero' => 'Indie', 'portada' => 'indie.jpg'],
    'hiphop1' => ['titulo' => 'Hip Hop Beat', 'artista' => 'vaitsez', 'genero' => 'Hip-Hop', 'portada' => 'hiphop.jpg'],
    'hiphop2' => ['titulo' => 'Hip Hop Groove', 'artista' => 'prettyjohn1', 'genero' => 'Hip-Hop', 'portada' => 'hiphop.jpg'],
    'electronica1' => ['titulo' => 'Abstract Electronica', 'artista' => 'arpmedia', 'genero' => 'Electrónica', 'portada' => 'electronica.jpg'],
    'electronica2' => ['titulo' => 'Retrowave', 'artista' => 'the_mountain', 'genero' => 'Electrónica', 'portada' => 'electronica.jpg'],
    'metal1' => ['titulo' => 'Thrash Metal', 'artista' => 'alex-morgan', 'genero' => 'Metal', 'portada' => 'metal.jpg'],
    'metal2' => ['titulo' => 'Metal Music', 'artista' => 'jonasblakewood', 'genero' => 'Metal', 'portada' => 'metal.jpg'],
];

$id = $_GET['id'] ?? 'rock1';
if (!isset($canciones[$id])) {
    $id = 'rock1';
}
$c = $canciones[$id];

$titulo_pagina = $c['titulo'];
require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main class="container py-5">
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="row g-4 align-items-center">
                <div class="col-md-5">
                    <div class="portada" role="img" aria-label="Portada de <?= $c['titulo']; ?>"
                         style="background-image: url('img/<?= $c['portada']; ?>');"></div>
                </div>
                <div class="col-md-7">
                    <h1 class="h2"><?= $c['titulo']; ?></h1>
                    <p class="texto-suave"><?= $c['artista']; ?> · <?= $c['genero']; ?></p>
                    <audio controls class="w-100 mt-3">
                        <source src="audio/<?= $id; ?>.mp3" type="audio/mpeg">
                        Tu navegador no soporta audio.
                    </audio>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <h2 class="h5 mb-3">Más canciones</h2>
            <?php foreach ($canciones as $otro_id => $o): ?>
                <?php if ($otro_id === $id) continue; ?>
                <a href="cancion.php?id=<?= $otro_id; ?>" class="fila-ranking text-decoration-none text-white">
                    <div>
                        <div class="fw-semibold"><?= $o['titulo']; ?></div>
                        <div class="texto-suave small"><?= $o['artista']; ?> · <?= $o['genero']; ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>