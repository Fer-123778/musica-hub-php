<?php
$titulo_pagina = "Agregar canción";
$base = '../';
require_once '../config/conexion.php';
require_once '../includes/auth_guard.php';
requerir_login('../login.php');

$artistas = $pdo->query("SELECT id, nombre FROM artistas ORDER BY nombre")->fetchAll();
$generos = $pdo->query("SELECT id, nombre FROM generos ORDER BY nombre")->fetchAll();

$cancion = ['titulo' => '', 'archivo_audio' => '', 'id_artista' => '', 'id_genero' => ''];
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
        $sql = "INSERT INTO canciones (titulo, archivo_audio, id_artista, id_genero)
                VALUES (:titulo, :archivo_audio, :id_artista, :id_genero)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titulo' => $cancion['titulo'],
            ':archivo_audio' => $cancion['archivo_audio'],
            ':id_artista' => (int) $cancion['id_artista'],
            ':id_genero' => (int) $cancion['id_genero'],
        ]);
        header('Location: index.php?status=created');
        exit;
    }
}

$texto_boton = 'Guardar canción';
require_once '../includes/header.php';
require_once '../includes/nav.php';
?>

<main class="container py-5" style="max-width: 720px;">
    <h1 class="mb-4">Agregar canción</h1>

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