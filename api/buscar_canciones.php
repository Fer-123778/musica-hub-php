<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../config/conexion.php';

function responder(int $codigo, array $cuerpo): void
{
    http_response_code($codigo);
    echo json_encode($cuerpo, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    responder(405, ['status' => 'error', 'message' => 'Método no permitido.']);
}

$q = trim($_GET['q'] ?? '');
if (mb_strlen($q) > 50) {
    responder(400, ['status' => 'error', 'message' => 'La búsqueda no puede superar los 50 caracteres.']);
}

// Escapa los comodines de LIKE para que el usuario no los use
$patron = '%' . addcslashes($q, '%_\\') . '%';

try {
    $sql = "SELECT c.id, c.titulo, c.archivo_audio, a.nombre AS artista,
                   g.nombre AS genero, COUNT(v.id_usuario) AS estrellas
            FROM canciones c
            INNER JOIN artistas a ON c.id_artista = a.id
            INNER JOIN generos g ON c.id_genero = g.id
            LEFT JOIN votos v ON v.id_cancion = c.id
            WHERE c.titulo LIKE :q1 OR a.nombre LIKE :q2 OR g.nombre LIKE :q3
            GROUP BY c.id, c.titulo, c.archivo_audio, a.nombre, g.nombre
            ORDER BY estrellas DESC, c.titulo ASC
            LIMIT 20";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':q1' => $patron, ':q2' => $patron, ':q3' => $patron]);
    $canciones = $stmt->fetchAll();

    if ($q !== '' && empty($canciones)) {
        responder(404, ['status' => 'not_found', 'message' => 'No se encontraron canciones.', 'data' => []]);
    }

    responder(200, ['status' => 'success', 'total' => count($canciones), 'data' => $canciones]);
} catch (PDOException $e) {
    responder(500, ['status' => 'error', 'message' => 'Error al consultar la base de datos.']);
}