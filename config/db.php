<?php
/**
 * CONFIGURACIÓN DE CONEXIÓN A BASE DE DATOS
 * Sistema: Visión Real - Tienda de Ropa
 */

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'vision_real');
define('DB_PORT', 3306);
define('DB_CHARSET', 'utf8mb4');

try {
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);
    if ($conexion->connect_error) {
        throw new Exception("Error: " . $conexion->connect_error);
    }
    $conexion->set_charset(DB_CHARSET);
} catch (Exception $e) {
    die("❌ Error de conexión: " . $e->getMessage());
}

function escapar($valor) {
    global $conexion;
    return $conexion->real_escape_string($valor);
}

function sanitizar($valor) {
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

function validarSesion() {
    if (!isset($_SESSION['id_usuario'])) {
        header('Location: /vision-real/index.php?action=login');
        exit;
    }
}

function validarRol($rolesPermitidos = []) {
    validarSesion();
    if (!in_array($_SESSION['rol_id'], $rolesPermitidos)) {
        die("❌ No tiene permiso para acceder a esta página");
    }
}
?>