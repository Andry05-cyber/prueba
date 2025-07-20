<?php
// ==============================
// SIN CIFRADO — SOLO PARA PRUEBAS
// ==============================

// ==============================
// Parámetros de conexión
// ==============================
$host   = '127.0.0.1';
$user   = 'root';
$pass   = '';
$dbName = 'proyecto_final';

// 1) Conectar al servidor MySQL
$mysqli = new mysqli($host, $user, $pass);
if ($mysqli->connect_error) {
    die('Error de conexión: ' . $mysqli->connect_error);
}

// 2) Crear base de datos si no existe
$mysqli->query("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
$mysqli->select_db($dbName);

// ==============================
// 3) Crear tablas
// ==============================

// Tabla usuarios
$mysqli->query("
CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombres VARCHAR(100),
  apellidos VARCHAR(100),
  fecha_nacimiento DATE,
  cedula VARCHAR(20),
  telefono VARCHAR(20),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(255),
  curso_id INT,
  monto DECIMAL(10,2),
  pagado TINYINT(1) DEFAULT 0,
  rol ENUM('estudiante','admin') DEFAULT 'estudiante',
  registrado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;
");

// Tabla cursos
$mysqli->query("
CREATE TABLE IF NOT EXISTS cursos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  horas INT,
  valor DECIMAL(10,2),
  num_estudiantes INT DEFAULT 0
) ENGINE=InnoDB;
");

// Tabla quejas
$mysqli->query("
CREATE TABLE IF NOT EXISTS quejas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT,
  queja TEXT,
  respuesta TEXT,
  enviado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;
");

// Tabla calificaciones
$mysqli->query("
CREATE TABLE IF NOT EXISTS calificaciones (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT,
  curso_id INT,
  clase VARCHAR(50),
  act1 INT, act2 INT, act3 INT, act4 INT,
  prueba INT,
  prueba_final INT,
  nota_final DECIMAL(5,2),
  registrado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(usuario_id) REFERENCES usuarios(id),
  FOREIGN KEY(curso_id) REFERENCES cursos(id)
) ENGINE=InnoDB;
");

// ==============================
// 4) Datos por defecto
// ==============================

// Verificar si ya existe el admin
$admin_email = 'admin@dominio.com';
$check_admin = $mysqli->prepare("SELECT id FROM usuarios WHERE email = ?");
$check_admin->bind_param('s', $admin_email);
$check_admin->execute();
$check_admin->store_result();

if ($check_admin->num_rows === 0) {
    // Contraseña sin cifrar para pruebas
    $admin_pass = 'admin123';  // ✅ SE PUEDE VER EN PHPMYADMIN

    $stmt = $mysqli->prepare("
        INSERT INTO usuarios (nombres, apellidos, email, password, rol)
        VALUES (?, ?, ?, ?, ?)
    ");
    $nombres = 'Admin';
    $apellidos = 'Default';
    $rol = 'admin';
    $stmt->bind_param('sssss', $nombres, $apellidos, $admin_email, $admin_pass, $rol);
    $stmt->execute();
    $stmt->close();
}
$check_admin->close();

// Insertar cursos iniciales si no existen
$result = $mysqli->query("SELECT COUNT(*) as total FROM cursos");
$row = $result->fetch_assoc();
$total = $row['total'];
if ($total == 0) {
    $mysqli->query("
        INSERT INTO cursos (nombre, horas, valor) VALUES
        ('Python', 40, 30.00),
        ('HTML', 60, 90.00)
    ");
}
?>
