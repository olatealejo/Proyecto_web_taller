-- Crear base de datos (ejecutar solo si no existe)
CREATE DATABASE IF NOT EXISTS proyecto_taller;
USE proyecto_taller;

-- Crear tabla de usuarios
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefono VARCHAR(20),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insertar algunos usuarios de ejemplo (opcional)
INSERT INTO usuarios (nombre, email, telefono) VALUES
('Juan Pérez', 'juan@example.com', '2991234567'),
('María García', 'maria@example.com', '2992345678'),
('Carlos López', 'carlos@example.com', '2993456789');

