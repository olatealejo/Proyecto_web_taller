<?php
/**
 * Archivo para crear un nuevo producto
 */
require_once '../php/config.php';

header('Content-Type: application/json; charset=utf-8');

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener datos del POST
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
$categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';
$precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0;
$stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;
$imagen = isset($_POST['imagen']) ? trim($_POST['imagen']) : '';

// Validar datos requeridos
$errores = array();

if (empty($nombre)) {
    $errores[] = 'El nombre es requerido';
}

if (empty($categoria)) {
    $errores[] = 'La categoría es requerida';
}

if ($precio <= 0) {
    $errores[] = 'El precio debe ser mayor a 0';
}

if (count($errores) > 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Error de validación',
        'errors' => $errores
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$conexion = conectarDB();

// Preparar consulta con prepared statement para prevenir SQL injection
$sql = "INSERT INTO productos (nombre, descripcion, categoria, precio, stock, imagen) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conexion->prepare($sql);

if (!$stmt) {
    cerrarDB($conexion);
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al preparar la consulta: ' . $conexion->error
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$stmt->bind_param("sssdds", $nombre, $descripcion, $categoria, $precio, $stock, $imagen);

if ($stmt->execute()) {
    $id_nuevo = $conexion->insert_id;
    
    // Obtener el producto creado
    $sql_select = "SELECT id, nombre, descripcion, categoria, precio, stock, imagen,
                          DATE_FORMAT(fecha_creacion, '%d/%m/%Y %H:%i') as fecha_creacion,
                          DATE_FORMAT(fecha_actualizacion, '%d/%m/%Y %H:%i') as fecha_actualizacion
                   FROM productos 
                   WHERE id = ?";
    
    $stmt_select = $conexion->prepare($sql_select);
    $stmt_select->bind_param("i", $id_nuevo);
    $stmt_select->execute();
    $resultado = $stmt_select->get_result();
    $producto = $resultado->fetch_assoc();
    
    $stmt_select->close();
    
    echo json_encode([
        'success' => true,
        'message' => 'Producto creado exitosamente',
        'data' => $producto
    ], JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al crear el producto: ' . $stmt->error
    ], JSON_UNESCAPED_UNICODE);
}

$stmt->close();
cerrarDB($conexion);
?>


