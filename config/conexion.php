<?php
/**
 * CONFIGURACIÓN DE CONEXIÓN A BASE DE DATOS
 * Sistema: Visión Real - Tienda de Ropa
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'vision_real');
define('DB_PORT', 3306);
define('DB_CHARSET', 'utf8mb4');

// Crear conexión
try {
    $conexion = new mysqli(
        DB_HOST,
        DB_USER,
        DB_PASS,
        DB_NAME,
        DB_PORT
    );

    // Verificar conexión
    if ($conexion->connect_error) {
        throw new Exception("Error de conexión: " . $conexion->connect_error);
    }

    // Configurar charset
    $conexion->set_charset(DB_CHARSET);

} catch (Exception $e) {
    die("❌ Error de conexión a la base de datos: " . $e->getMessage());
}

// Funciones auxiliares de seguridad
function escapar($valor) {
    global $conexion;
    return $conexion->real_escape_string($valor);
}

function sanitizar($valor) {
    return htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
}

// Validar sesión y rol
function validarSesion() {
    if (!isset($_SESSION['id_usuario'])) {
        header('Location: /vision-real-ecommerce/index.php?action=login');
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
