<?php
$titulo_pagina = "Editar canción";
$base = '../';
require_once '../config/conexion.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM canciones WHERE id = :id");
$stmt->execute([':id' => $id]);
$cancion = $stmt->fetch();
if (!$cancion) {
    header('Location: index.php');
    exit;
}

$artistas = $pdo->query("SELECT id, nombre FROM artistas ORDER BY nombre")->fetchAll();
$generos = $pdo->query("SELECT id, nombre FROM generos ORDER BY nombre")->fetchAll();
$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cancion['titulo'] = trim($_POST['titulo'] ?? '');
    $cancion['archivo_audio'] = trim($_POST['archivo_audio'] ?? '');
    $cancion['id_artista'] = $_POST['id_artista'] ?? '';
    $cancion['id_genero'] = $_POST['id_genero'] ?? '';

    if (empty($cancion['titulo'])) {
        $errores[] = 'El título es obligatorio.';
    }
    if (empty($cancion['archivo_audio'])) {
        $errores[] = 'El archivo de audio es obligatorio.';
    }
    if (!filter_var($cancion['id_artista'], FILTER_VALIDATE_INT)) {
        $errores[] = 'Elegí un artista.';
    }
    if (!filter_var($cancion['id_genero'], FILTER_VALIDATE_INT)) {
        $errores[] = 'Elegí un género.';
    }

    if (empty($errores)) {
        $sql = "UPDATE canciones
                SET titulo = :titulo, archivo_audio = :archivo_audio,
                    id_artista = :id_artista, id_genero = :id_genero
                WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $cancion['titulo'],
            ':archivo_audio' => $cancion['archivo_audio'],
            ':id_artista' => (int) $cancion['id_artista'],
            ':id_genero' => (int) $cancion['id_genero'],
            ':id' => $id,
        ]);
        header('Location: index.php?status=updated');
        exit;
    }
}

$texto_boton = 'Guardar cambios';
require_once '../includes/header.php';
require_once '../includes/nav.php';
?>

<main class="container py-5" style="max-width: 720px;">
    <h1 class="mb-4">Editar canción</h1>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                <?php foreach ($errores as $error): ?>
                    <li><?= h($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php require '_formulario.php'; ?>
</main>

<?php require_once '../includes/footer.php'; ?>