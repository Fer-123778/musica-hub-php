<?php
$titulo_pagina = "Administrar canciones";
$base = '../';
require_once '../config/conexion.php';
require_once '../includes/header.php';
require_once '../includes/nav.php';

$estado = $_GET['status'] ?? '';
$mensajes = [
    'created' => 'La canción se agregó correctamente.',
    'updated' => 'La canción se actualizó correctamente.',
    'deleted' => 'La canción se eliminó correctamente.',
];

$sql = "SELECT c.id, c.titulo, c.archivo_audio, a.nombre AS artista, g.nombre AS genero
        FROM canciones c
        INNER JOIN artistas a ON c.id_artista = a.id
        INNER JOIN generos g ON c.id_genero = g.id
        ORDER BY c.id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$canciones = $stmt->fetchAll();
?>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Administrar canciones</h1>
        <a href="crear.php" class="btn btn-musica">Agregar canción</a>
    </div>

    <?php if (isset($mensajes[$estado])): ?>
        <div class="alert alert-success" role="alert"><?= h($mensajes[$estado]); ?></div>
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
                            <a href="editar.php?id=<?= (int) $c['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="eliminar.php?id=<?= (int) $c['id']; ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('¿Confirma eliminar esta canción?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>