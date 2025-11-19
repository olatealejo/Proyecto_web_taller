<?php
/**
 * Archivo para eliminar un producto
 */
require_once '../php/config.php';

header('Content-Type: application/json; charset=utf-8');

// Verificar que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

// Obtener ID del POST
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

// Validar ID
if ($id <= 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'ID de producto inválido'
    ], JSON_UNESCAPED_UNICODE);
    exit;
}

$conexion = conectarDB();

// Verificar que el producto existe
$sql_check = "SELECT id, nombre FROM productos WHERE id = ?";
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

$producto = $resultado_check->fetch_assoc();
$stmt_check->close();

// Eliminar el producto
$sql = "DELETE FROM productos WHERE id = ?";
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

$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Producto eliminado exitosamente',
        'data' => ['id' => $id, 'nombre' => $producto['nombre']]
    ], JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al eliminar el producto: ' . $stmt->error
    ], JSON_UNESCAPED_UNICODE);
}

$stmt->close();
cerrarDB($conexion);
?>


