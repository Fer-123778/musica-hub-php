<?php
$env = parse_ini_file(__DIR__ . '/../.env');

$host    = $env['DB_HOST'] ?? '127.0.0.1';
$port    = $env['DB_PORT'] ?? '3307';
$db      = $env['DB_NAME'] ?? 'musica_hub';
$user    = $env['DB_USER'] ?? 'root';
$pass    = $env['DB_PASS'] ?? '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Escapa texto antes de imprimirlo en HTML (prevención de XSS)
function h($valor): string
{
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Error crítico de conexión con la base de datos.');
}