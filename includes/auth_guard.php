<?php
// Requiere config/conexion.php cargado antes (usa la función h()).
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function requerir_login(string $ruta_login = 'login.php'): void
{
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ' . $ruta_login . '?error=acceso_denegado');
        exit;
    }
}

function requerir_rol(string $rol, string $ruta_login = 'login.php'): void
{
    requerir_login($ruta_login);
    if (($_SESSION['rol'] ?? '') !== $rol) {
        header('Location: ' . $ruta_login . '?error=sin_permiso');
        exit;
    }
}