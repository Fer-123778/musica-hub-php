<?php
require_once __DIR__ . '/../../../includes/header.php';
require_once __DIR__ . '/../../../includes/nav.php';
?>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Administrar canciones</h1>
        <a href="canciones.php?accion=crear" class="btn btn-musica">Agregar canción</a>
    </div>

    <?php if ($mensaje !== ''): ?>
        <div class="alert alert-success" role="alert"><?= h($mensaje); ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Artista</th>
                    <th>Género</th>
                    <th>Audio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($canciones as $c): ?>
                    <tr>
                        <td><?= h($c['id']); ?></td>
                        <td><?= h($c['titulo']); ?></td>
                        <td><?= h($c['artista']); ?></td>
                        <td><?= h($c['genero']); ?></td>
                        <td><?= h($c['archivo_audio']); ?></td>
                        <td>
                            <a href="canciones.php?accion=editar&id=<?= (int) $c['id']; ?>"
                               class="btn btn-sm btn-warning">Editar</a>
                            <a href="canciones.php?accion=eliminar&id=<?= (int) $c['id']; ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('¿Confirma eliminar esta canción?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php require_once __DIR__ . '/../../../includes/footer.php'; ?>