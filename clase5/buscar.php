<?php
$titulo_pagina = "Buscar";
$base = '../';
require_once 'datos.php';
require_once '../includes/header.php';
require_once '../includes/nav.php';

$generos_validos = ['Rock', 'Pop', 'Indie', 'Hip-Hop', 'Electrónica', 'Metal'];

$enviado = isset($_GET['q']) || isset($_GET['genero']);
$q = mb_substr(trim($_GET['q'] ?? ''), 0, 50);
$genero = $_GET['genero'] ?? '';
if (!in_array($genero, $generos_validos, true)) {
    $genero = '';
}

$error = '';
$resultados = [];

if ($enviado) {
    if (empty($q) && empty($genero)) {
        $error = 'Escribí un artista o canción, o elegí un género.';
    } else {
        foreach ($catalogo as $c) {
            $texto_ok = empty($q) || mb_stripos($c['titulo'] . ' ' . $c['artista'], $q) !== false;
            $genero_ok = empty($genero) || $c['genero'] === $genero;
            if ($texto_ok && $genero_ok) {
                $resultados[] = $c;
            }
        }
    }
}
?>

<main class="container py-5" style="max-width: 720px;">
    <h1 class="mb-4">Buscar música</h1>

    <form method="get" action="buscar.php" class="tarjeta mb-4" data-bs-theme="dark">
        <div class="row g-3 align-items-end">
            <div class="col-md-6">
                <label for="q" class="form-label">Artista o canción</label>
                <input type="text" class="form-control" id="q" name="q" value="<?= limpiar($q); ?>">
            </div>
            <div class="col-md-4">
                <label for="genero" class="form-label">Género</label>
                <select class="form-select" id="genero" name="genero">
                    <option value="">Todos</option>
                    <?php foreach ($generos_validos as $g): ?>
                        <option value="<?= $g; ?>" <?= $genero === $g ? 'selected' : ''; ?>><?= $g; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-musica w-100">Buscar</button>
            </div>
        </div>
    </form>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger" role="alert"><?= $error; ?></div>
    <?php elseif ($enviado): ?>
        <p class="texto-suave">
            <?= count($resultados); ?> resultado(s) para "<?= limpiar($q); ?>"
            <?= !empty($genero) ? 'en ' . limpiar($genero) : ''; ?>
        </p>
        <?php foreach ($resultados as $c): ?>
            <a href="../cancion.php?id=<?= limpiar($c['id']); ?>" class="fila-ranking text-decoration-none text-white">
                <div>
                    <div class="fw-semibold"><?= limpiar($c['titulo']); ?></div>
                    <div class="texto-suave small"><?= limpiar($c['artista']); ?> · <?= limpiar($c['genero']); ?></div>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

<?php require_once '../includes/footer.php'; ?>