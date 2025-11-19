<?php
/**
 * Configuración de conexión a la base de datos
 * Ajusta estos valores según tu configuración de MySQL
 */

// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'musical_instruments');
define('DB_CHARSET', 'utf8mb4');

/**
 * Función para establecer conexión con la base de datos
 * @return mysqli|false Retorna el objeto de conexión o false en caso de error
 */
function conectarDB() {
    $conexion = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Verificar conexión
    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }
    
    // Establecer charset
    $conexion->set_charset(DB_CHARSET);
    
    return $conexion;
}

/**
 * Función para cerrar la conexión
 * @param mysqli $conexion Objeto de conexión
 */
function cerrarDB($conexion) {
    if ($conexion) {
        $conexion->close();
    }
}
?>


