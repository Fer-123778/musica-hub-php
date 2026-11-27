<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($titulo ?? 'Música Hub') ?> | Música Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/musica-hub-php/css/estilos.css">
</head>
<body>
    <nav class="navbar navbar-dark nav-musica">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/musica-hub-php/index.php">♪ Música Hub</a>
            <span class="texto-suave small">Módulo hecho con CodeIgniter 4</span>
        </div>
    </nav>

    <?= $this->renderSection('contenido') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>