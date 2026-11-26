<?php
$titulo_pagina = "Explorar";
$base = '../';
require_once 'datos.php';
require_once '../includes/header.php';
require_once '../includes/nav.php';

function parametro(string $clave, string $defecto = ''): string
{
    $valor = $_GET[$clave] ?? $defecto;
    return is_string($valor) ? $valor : $defecto;
}

function enlace_explorar(string $q, string $genero, string $tipo, string $orden): string
{
    return 'buscar.php?' . http_build_query([
        'q' => $q, 'genero' => $genero, 'tipo' => $tipo, 'orden' => $orden,
    ]);
}

$generos_validos = ['Rock', 'Pop', 'Indie', 'Hip-Hop', 'Electrónica', 'Metal'];
$tipos = ['todo' => 'Todo', 'canciones' => 'Canciones', 'artistas' => 'Artistas'];
$ordenes = [
    'titulo'  => 'Título (A-Z)',
    'artista' => 'Artista (A-Z)',
    'genero'  => 'Género (A-Z)',
];
$imagenes = [
    'Rock' => 'rock.jpg', 'Pop' => 'pop.jpg', 'Indie' => 'indie.jpg',
    'Hip-Hop' => 'hiphop.jpg', 'Electrónica' => 'electronica.jpg', 'Metal' => 'metal.jpg',
];

// Captura y sanitización de lo que llega por GET
$q = mb_substr(trim(parametro('q')), 0, 50);
$genero = parametro('genero');
$tipo = parametro('tipo', 'todo');
$orden = parametro('orden', 'titulo');
$errores = [];

if ($genero !== '' && !in_array($genero, $generos_validos, true)) {
    $errores[] = 'El género elegido no es válido.';
    $genero = '';
}
if (!array_key_exists($tipo, $tipos)) {
    $errores[] = 'El tipo de contenido no es válido.';
    $tipo = 'todo';
}
if (!array_key_exists($orden, $ordenes)) {
    $errores[] = 'El orden elegido no es válido.';
    $orden = 'titulo';
}

// Canciones que cumplen el texto y el género
$canciones = [];
foreach ($catalogo as $c) {
    $texto_ok = $q === '' || mb_stripos($c['titulo'] . ' ' . $c['artista'] . ' ' . $c['genero'], $q) !== false;
    $genero_ok = $genero === '' || $c['genero'] === $genero;
    if ($texto_ok && $genero_ok) {
        $canciones[] = $c;
    }
}
usort($canciones, fn($a, $b) => strcasecmp($a[$orden], $b[$orden]));

// Artistas (sin repetir) que cumplen el texto y el género
$artistas = [];
foreach ($catalogo as $c) {
    if ($q !== '' && mb_stripos($c['artista'], $q) === false) {
        continue;
    }
    if ($genero !== '' && $c['genero'] !== $genero) {
        continue;
    }
    if (!isset($artistas[$c['artista']])) {
        $artistas[$c['artista']] = ['nombre' => $c['artista'], 'genero' => $c['genero'], 'total' => 0];
    }
    $artistas[$c['artista']]['total']++;
}
$artistas = array_values($artistas);
usort($artistas, fn($a, $b) => strcasecmp($a['nombre'], $b['nombre']));
?>

<main class="container py-5" style="max-width: 1100px;">
    <h1 class="display-5 fw-bold texto-degradado mb-1">Explorar</h1>
    <p class="texto-suave mb-4">Descubrí toda la música disponible en la plataforma.</p>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                <?php foreach ($errores as $error): ?>
                    <li><?= limpiar($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="get" action="buscar.php" role="search" class="mb-4" data-bs-theme="dark">
        <input type="hidden" name="tipo" value="<?= limpiar($tipo); ?>">

        <div class="row g-2 mb-3">
            <div class="col">
                <label for="q" class="visually-hidden">Buscar por título, artista o género</label>
               <input type="search" class="form-control form-control-lg" id="q" name="q"
       placeholder="Buscá un título, un artista o un género" maxlength="50"
       value="<?= limpiar($q); ?>">
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-musica btn-lg">Buscar</button>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-3 align-items-center">
            <div class="pestanas" role="navigation" aria-label="Tipo de contenido">
                <?php foreach ($tipos as $clave => $texto): ?>
                    <a class="pestana <?= $tipo === $clave ? 'activa' : ''; ?>"
                       href="<?= limpiar(enlace_explorar($q, $genero, $clave, $orden)); ?>"
                       <?= $tipo === $clave ? 'aria-current="page"' : ''; ?>><?= limpiar($texto); ?></a>
                <?php endforeach; ?>
            </div>

            <label for="genero" class="visually-hidden">Género</label>
            <select class="form-select form-select-lg" id="genero" name="genero"
                    style="width: auto; min-width: 220px;" onchange="this.form.submit()">
                <option value="">Todos los géneros</option>
                <?php foreach ($generos_validos as $g): ?>
                    <option value="<?= limpiar($g); ?>" <?= $genero === $g ? 'selected' : ''; ?>><?= limpiar($g); ?></option>
                <?php endforeach; ?>
            </select>

            <label for="orden" class="visually-hidden">Ordenar por</label>
            <select class="form-select form-select-lg" id="orden" name="orden"
                    style="width: auto; min-width: 200px;" onchange="this.form.submit()">
                <?php foreach ($ordenes as $clave => $texto): ?>
                    <option value="<?= limpiar($clave); ?>" <?= $orden === $clave ? 'selected' : ''; ?>><?= limpiar($texto); ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>

    <?php if ($tipo === 'todo' || $tipo === 'canciones'): ?>
        <h2 class="h4 mb-3">Canciones</h2>
        <?php if (empty($canciones)): ?>
            <p class="texto-suave mb-5">No hay canciones con esos criterios.</p>
        <?php else: ?>
            <p class="texto-suave"><?= count($canciones); ?> canción(es)</p>
            <div class="row g-4 mb-5">
                <?php foreach ($canciones as $c): ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="../cancion.php?id=<?= limpiar($c['id']); ?>"
                           class="tarjeta-explorar d-block text-decoration-none text-white">
                            <div class="portada-img" role="img"
                                 aria-label="Portada de <?= limpiar($c['titulo']); ?>"
                                 style="background-image: url('../img/<?= limpiar($imagenes[$c['genero']] ?? 'rock.jpg'); ?>');"></div>
                            <div class="cuerpo">
                                <h3 class="h6 mb-1"><?= limpiar($c['titulo']); ?></h3>
                                <p class="texto-suave small mb-0"><?= limpiar($c['artista']); ?> · <?= limpiar($c['genero']); ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($tipo === 'todo' || $tipo === 'artistas'): ?>
        <h2 class="h4 mb-3">Artistas</h2>
        <?php if (empty($artistas)): ?>
            <p class="texto-suave">No hay artistas con esos criterios.</p>
        <?php else: ?>
            <p class="texto-suave"><?= count($artistas); ?> artista(s)</p>
            <div class="row g-4">
                <?php foreach ($artistas as $a): ?>
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="<?= limpiar(enlace_explorar($a['nombre'], '', 'canciones', 'titulo')); ?>"
                           class="tarjeta-explorar d-block text-decoration-none text-white">
                            <div class="portada-img" role="img"
                                 aria-label="Foto de <?= limpiar($a['nombre']); ?>"
                                 style="background-image: url('../img/<?= limpiar($imagenes[$a['genero']] ?? 'rock.jpg'); ?>');"></div>
                            <div class="cuerpo">
                                <h3 class="h6 mb-1"><?= limpiar($a['nombre']); ?></h3>
                                <p class="texto-suave small mb-0">Artista · <?= (int) $a['total']; ?> canción(es)</p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</main>

<?php require_once '../includes/footer.php'; ?>