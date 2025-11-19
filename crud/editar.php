<?php
/**
 * Archivo para editar un producto existente
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
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
$descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : '';
$categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';
$precio = isset($_POST['precio']) ? floatval($_POST['precio']) : 0;
$stock = isset($_POST['stock']) ? intval($_POST['stock']) : 0;
$imagen = isset($_POST['imagen']) ? trim($_POST['imagen']) : '';

// Validar datos requeridos
$errores = array();

if ($id <= 0) {
    $errores[] = 'ID de producto inválido';
}

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

// Verificar que el producto existe
$sql_check = "SELECT id FROM productos WHERE id = ?";
$stmt_check = $conexion->prepare($sql_check);
$stmt_check->bind_param("i", $id);
$stmt_check->execute();
$resultado_check = $stmt_check->get_result();

if ($resultado_check->num_rows === 0) {
    $stmt_check->close();
    cerrarDB($conexion);
    http_response_code(404);
    echo json_encode([
        'success' => false,
        'message' => 'Producto no encontrado'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$stmt_check->close();

// Preparar consulta con prepared statement para prevenir SQL injection
$sql = "UPDATE productos 
        SET nombre = ?, descripcion = ?, categoria = ?, precio = ?, stock = ?, imagen = ?
        WHERE id = ?";

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

$stmt->bind_param("sssddsi", $nombre, $descripcion, $categoria, $precio, $stock, $imagen, $id);

if ($stmt->execute()) {
    // Obtener el producto actualizado
    $sql_select = "SELECT id, nombre, descripcion, categoria, precio, stock, imagen,
                          DATE_FORMAT(fecha_creacion, '%d/%m/%Y %H:%i') as fecha_creacion,
                          DATE_FORMAT(fecha_actualizacion, '%d/%m/%Y %H:%i') as fecha_actualizacion
                   FROM productos 
                   WHERE id = ?";
    
    $stmt_select = $conexion->prepare($sql_select);
    $stmt_select->bind_param("i", $id);
    $stmt_select->execute();
    $resultado = $stmt_select->get_result();
    $producto = $resultado->fetch_assoc();
    
    $stmt_select->close();
    
    echo json_encode([
        'success' => true,
        'message' => 'Producto actualizado exitosamente',
        'data' => $producto
    ], JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al actualizar el producto: ' . $stmt->error
    ], JSON_UNESCAPED_UNICODE);
}

$stmt->close();
cerrarDB($conexion);
?>


