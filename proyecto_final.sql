-- Dump de la base de datos proyecto_final
CREATE DATABASE IF NOT EXISTS `proyecto_final` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `proyecto_final`;

-- Tabla usuarios
CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `cedula` varchar(20) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `curso_id` int(11) DEFAULT NULL,
  `monto` decimal(10,2) DEFAULT NULL,
  `pagado` tinyint(1) DEFAULT '0',
  `rol` enum('estudiante','admin') DEFAULT 'estudiante',
  `registrado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB;

-- Tabla cursos
CREATE TABLE `cursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `horas` int(11) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `num_estudiantes` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- Tabla quejas
CREATE TABLE `quejas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `queja` text,
  `respuesta` text,
  `enviado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `usuario_id` (`usuario_id`)
) ENGINE=InnoDB;

-- Tabla calificaciones
CREATE TABLE `calificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) DEFAULT NULL,
  `curso_id` int(11) DEFAULT NULL,
  `clase` varchar(50) DEFAULT NULL,
  `act1` int(11) DEFAULT NULL,
  `act2` int(11) DEFAULT NULL,
  `act3` int(11) DEFAULT NULL,
  `act4` int(11) DEFAULT NULL,
  `prueba` int(11) DEFAULT NULL,
  `prueba_final` int(11) DEFAULT NULL,
  `nota_final` decimal(5,2) DEFAULT NULL,
  `registrado_en` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- Datos por defecto
INSERT IGNORE INTO `usuarios` (`nombres`,`apellidos`,`email`,`password`,`rol`)
VALUES 
  ('Admin','Default','admin@dominio.com','12345', 'admin');

INSERT IGNORE INTO `cursos` (`nombre`,`horas`,`valor`)
VALUES
  ('Python', 40, 30.00),
  ('HTML',   60, 90.00);
