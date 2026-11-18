<?php
$titulo_pagina = "Inicio";
require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main class="container">
    <section class="hero">
        <h1>Descubrí tu próxima<br><span class="texto-degradado">canción favorita</span></h1>
        <p class="texto-suave fs-5 mt-3">
            Bienvenido a <?= APP_NAME; ?>. Rankings votados por la comunidad, noticias y recomendaciones.
        </p>
        <a href="rankings.php" class="btn btn-musica mt-3">Ver rankings</a>
    </section>

    <section class="row g-4">
        <div class="col-md-4">
            <div class="tarjeta">
                <h2 class="h5">Lo nuevo</h2>
                <p class="texto-suave mb-0">Los lanzamientos de hoy y de esta semana.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tarjeta">
                <h2 class="h5">Rankings</h2>
                <p class="texto-suave mb-0">Las canciones más votadas por todos.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="tarjeta">
                <h2 class="h5">Giras</h2>
                <p class="texto-suave mb-0">Cuándo y dónde toca tu artista favorito.</p>
            </div>
        </div>
    </section>
</main>

<?php require_once 'includes/footer.php'; ?>