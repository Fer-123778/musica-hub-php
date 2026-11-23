<?php
$titulo_pagina = "Buscador en vivo";
require_once 'config/conexion.php';
require_once 'includes/header.php';
require_once 'includes/nav.php';
?>

<main class="container py-5" style="max-width: 760px;">
    <h1 class="mb-2">Buscador en vivo</h1>
    <p class="texto-suave mb-4">Escribí un título, un artista o un género. Los resultados aparecen sin recargar la página.</p>

    <form id="formBusqueda" class="mb-4" role="search" data-bs-theme="dark">
        <label for="inputBusqueda" class="form-label">Buscar canciones</label>
        <input type="search" class="form-control form-control-lg" id="inputBusqueda"
               placeholder="Ejemplo: rock, pop, Barcelona..." autocomplete="off" maxlength="50">
    </form>

    <p id="estadoBusqueda" class="texto-suave" role="status" aria-live="polite"></p>
    <div id="resultados"></div>
</main>

<?php require_once 'includes/footer.php'; ?>