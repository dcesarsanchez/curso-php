-- Base de datos para el ejemplo sencillo de CRUD con PDO
-- Importar en phpMyAdmin o con:  mysql -u root -p < tienda_demo.sql

CREATE DATABASE IF NOT EXISTS tienda_demo
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE tienda_demo;

CREATE TABLE IF NOT EXISTS productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL
);

-- Algunos productos de prueba
INSERT INTO productos (nombre, precio, stock) VALUES
('Ratón inalámbrico', 19.95, 25),
('Monitor 24 pulgadas', 129.00, 8),
('Alfombrilla', 6.50, 40);
