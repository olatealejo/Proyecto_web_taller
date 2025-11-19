<?php
require_once 'conexion.php';

// Procesar eliminación
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    try {
        $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        $mensaje = "Usuario eliminado correctamente";
        $tipo_mensaje = "success";
    } catch(PDOException $e) {
        $mensaje = "Error al eliminar usuario: " . $e->getMessage();
        $tipo_mensaje = "error";
    }
}

// Obtener todos los usuarios
try {
    $stmt = $conexion->query("SELECT * FROM usuarios ORDER BY fecha_registro DESC");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $usuarios = [];
    $mensaje = "Error al obtener usuarios: " . $e->getMessage();
    $tipo_mensaje = "error";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuarios</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
            border: none;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #218838;
        }
        .btn-editar {
            background-color: #007bff;
            padding: 5px 15px;
            font-size: 14px;
        }
        .btn-editar:hover {
            background-color: #0056b3;
        }
        .btn-eliminar {
            background-color: #dc3545;
            padding: 5px 15px;
            font-size: 14px;
        }
        .btn-eliminar:hover {
            background-color: #c82333;
        }
        .btn-volver {
            background-color: #6c757d;
            margin-top: 20px;
        }
        .btn-volver:hover {
            background-color: #5a6268;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .mensaje {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .mensaje.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .mensaje.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .acciones {
            display: flex;
            gap: 10px;
        }
        .vacio {
            text-align: center;
            padding: 40px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Panel de Gestión de Usuarios</h1>
        
        <?php if (isset($mensaje)): ?>
            <div class="mensaje <?php echo $tipo_mensaje; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>
        
        <a href="agregar_usuario.php" class="btn">➕ Agregar Nuevo Usuario</a>
        
        <?php if (empty($usuarios)): ?>
            <div class="vacio">
                <p>No hay usuarios registrados. <a href="agregar_usuario.php">Agregar primer usuario</a></p>
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['telefono'] ?? '-'); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($usuario['fecha_registro'])); ?></td>
                            <td>
                                <div class="acciones">
                                    <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-editar">✏️ Editar</a>
                                    <a href="?eliminar=<?php echo $usuario['id']; ?>" class="btn btn-eliminar" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">🗑️ Eliminar</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        
        <a href="../nosotros.html" class="btn btn-volver">← Volver a Nosotros</a>
    </div>
</body>
</html>

