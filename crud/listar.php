<?php
/**
 * Archivo para listar todos los productos
 */
require_once '../php/config.php';

header('Content-Type: application/json; charset=utf-8');

$conexion = conectarDB();

// Consulta para obtener todos los productos
$sql = "SELECT id, nombre, descripcion, categoria, precio, stock, imagen, 
               DATE_FORMAT(fecha_creacion, '%d/%m/%Y %H:%i') as fecha_creacion,
               DATE_FORMAT(fecha_actualizacion, '%d/%m/%Y %H:%i') as fecha_actualizacion
        FROM productos 
        ORDER BY fecha_creacion DESC";

$resultado = $conexion->query($sql);

$productos = array();

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        $productos[] = $fila;
    }
}

cerrarDB($conexion);

// Retornar JSON
echo json_encode([
    'success' => true,
    'data' => $productos,
    'total' => count($productos)
], JSON_UNESCAPED_UNICODE);
?>


