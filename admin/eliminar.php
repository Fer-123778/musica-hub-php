<?php
require_once '../config/conexion.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM canciones WHERE id = :id");
    $stmt->execute([':id' => $id]);
}

header('Location: index.php?status=deleted');
exit;