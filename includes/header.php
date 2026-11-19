<?php
require_once __DIR__ . '/../config/config.php';
$titulo_pagina = $titulo_pagina ?? APP_NAME;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= APP_NAME; ?> - Descubrí, votá y escuchá música.">
    <title><?= htmlspecialchars($titulo_pagina); ?> | <?= APP_NAME; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>