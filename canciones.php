<?php
require_once 'config/conexion.php';
require_once 'includes/auth_guard.php';
require_once 'app/Models/Cancion.php';
require_once 'app/Controllers/CancionController.php';

requerir_login('login.php');

$controlador = new CancionController(new Cancion($pdo));
$accion = $_GET['accion'] ?? 'index';

switch ($accion) {
    case 'crear':
        $controlador->crear();
        break;
    case 'editar':
        $controlador->editar();
        break;
    case 'eliminar':
        $controlador->eliminar();
        break;
    default:
        $controlador->index();
}