<?php
$base = $base ?? '';
$carpeta = basename(dirname($_SERVER['PHP_SELF']));
$archivo_actual = basename($_SERVER['PHP_SELF']);
$pagina_actual = in_array($carpeta, ['clase5', 'admin'], true)
    ? $carpeta . '/' . $archivo_actual
    : $archivo_actual;

$menu = [
    'index.php'            => 'Inicio',
    'noticias.php'         => 'Noticias',
    'rankings.php'         => 'Rankings',
    'generos.php'          => 'Géneros',
    'clase5/buscar.php'    => 'Buscar',
    'clase5/opiniones.php' => 'Opiniones',
    'admin/index.php'      => 'Administrar',
    'contacto.php'         => 'Contacto',
];
?>
<nav class="navbar navbar-expand-lg navbar-dark nav-musica">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= $base; ?>index.php">♪ <?= APP_NAME; ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#menuPrincipal" aria-controls="menuPrincipal"
                aria-expanded="false" aria-label="Abrir menú">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav ms-auto">
                <?php foreach ($menu as $archivo => $texto): ?>
                    <?php $activo = ($pagina_actual === $archivo)
                        || ($carpeta === 'admin' && $archivo === 'admin/index.php'); ?>
                    <li class="nav-item">
                        <a class="nav-link <?= $activo ? 'active' : ''; ?>"
                           href="<?= $base . $archivo; ?>"
                           <?= $activo ? 'aria-current="page"' : ''; ?>>
                            <?= $texto; ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>