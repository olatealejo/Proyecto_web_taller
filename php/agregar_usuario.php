<?php
require_once 'conexion.php';

$mensaje = '';
$tipo_mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    
    if (!empty($nombre) && !empty($email)) {
        try {
            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, telefono) VALUES (?, ?, ?)");
            $stmt->execute([$nombre, $email, $telefono]);
            $mensaje = "Usuario agregado correctamente";
            $tipo_mensaje = "success";
            
            // Limpiar campos después de agregar
            $_POST = [];
        } catch(PDOException $e) {
            if ($e->getCode() == 23000) {
                $mensaje = "El email ya existe en la base de datos";
            } else {
                $mensaje = "Error al agregar usuario: " . $e->getMessage();
            }
            $tipo_mensaje = "error";
        }
    } else {
        $mensaje = "Por favor completa todos los campos requeridos";
        $tipo_mensaje = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
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
            max-width: 600px;
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
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="tel"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        input:focus {
            outline: none;
            border-color: #007bff;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        .btn:hover {
            background-color: #218838;
        }
        .btn-volver {
            background-color: #6c757d;
            margin-top: 10px;
            text-align: center;
        }
        .btn-volver:hover {
            background-color: #5a6268;
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
        .required {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Agregar Nuevo Usuario</h1>
        
        <?php if ($mensaje): ?>
            <div class="mensaje <?php echo $tipo_mensaje; ?>">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="nombre">Nombre <span class="required">*</span></label>
                <input type="text" id="nombre" name="nombre" required 
                       value="<?php echo htmlspecialchars($_POST['nombre'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="email">Email <span class="required">*</span></label>
                <input type="email" id="email" name="email" required 
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
            </div>
            
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" 
                       value="<?php echo htmlspecialchars($_POST['telefono'] ?? ''); ?>">
            </div>
            
            <button type="submit" class="btn">Guardar Usuario</button>
        </form>
        
        <a href="panel_usuarios.php" class="btn btn-volver">← Volver al Panel</a>
    </div>
</body>
</html>

