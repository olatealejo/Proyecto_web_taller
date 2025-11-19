-- Script SQL para crear la base de datos y tabla de productos
-- Ejecutar este script en MySQL/MariaDB

CREATE DATABASE IF NOT EXISTS musical_instruments CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE musical_instruments;

-- Tabla de productos
CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT,
    categoria VARCHAR(100) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT DEFAULT 0,
    imagen VARCHAR(255),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar algunos productos de ejemplo
INSERT INTO productos (nombre, descripcion, categoria, precio, stock, imagen) VALUES
('Guitarra Fender Stratocaster', 'Clásico sonido eléctrico con gran versatilidad.', 'Cuerdas', 125000.00, 5, 'img/stratocaster.jpg'),
('Guitarra Acústica Yamaha F310', 'Perfecta para principiantes.', 'Cuerdas', 45000.00, 8, 'img/acusticaF310.jpg'),
('Piano Yamaha U1', 'Sonido profesional, ideal para estudio.', 'Cuerdas', 350000.00, 2, 'img/pianoU1.avif'),
('Teclado Casio CT-S200', 'Portátil y práctico.', 'Cuerdas', 65000.00, 12, 'img/tecladoCT-S200.webp'),
('Bajo Ibanez GSR200', 'Gran tono y comodidad para principiantes.', 'Cuerdas', 85000.00, 6, 'img/bajo.ibanez.jfif'),
('Trompeta Bach TR300', 'Excelente calidad de sonido y durabilidad.', 'Vientos', 180000.00, 4, 'img/trompeta.bach.jpg'),
('Saxofón Alto Yamaha YAS-280', 'Ideal para estudiantes avanzados.', 'Vientos', 320000.00, 3, 'img/saxo.yas280.webp'),
('Flauta Yamaha YFL-222', 'Perfecta para principiantes.', 'Vientos', 55000.00, 10, 'img/flauta.yfl222.webp'),
('Batería Pearl Export', 'Set completo con gran sonido.', 'Percusión', 280000.00, 3, 'img/bata.pe.jpg'),
('Bongós LP Aspire', 'Sonido cálido y construcción resistente.', 'Percusión', 45000.00, 7, 'img/bongos.lpa.jpg'),
('Congas Meinl Headliner', 'Perfectas para ritmos latinos.', 'Percusión', 95000.00, 5, 'img/congas.hc512.webp');


