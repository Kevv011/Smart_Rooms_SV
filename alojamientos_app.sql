-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 29, 2024 at 12:06 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `alojamientos_app`
--
-- ----------------------------------------------------------------------------------------

--
-- Tabla de `usuarios`
--

CREATE TABLE `usuarios` (
  `id` INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,	-- ID de la tabla usuarios
  `nombre` VARCHAR(100) NOT NULL,					-- Nombre usuario
  `apellido` VARCHAR(100) NOT NULL,					-- Apellido usuario
  `correo` VARCHAR(100) NOT NULL,					-- Correo de usuario
  `contrasenia` VARCHAR(255) NOT NULL,				-- Contraseña usuario
  `rol` ENUM('administrador','usuario', 'cliente', 'anfitrion')	 -- Rol por usuario
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 2;

-- ----------------------------------------------------------------------------------------

--
-- Tabla de anfitriones de alojamientos
-- 

CREATE TABLE `anfitriones` (
  `id` INT(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,			-- Campo ID anfitrion
  `id_usuario` INT(10) NOT NULL UNIQUE, 					-- Campo ID usuario para FK
  `biografia` TEXT NULL, 									-- Descripción breve del anfitrion
  `telefono` VARCHAR(20) NULL, 								-- Teléfono de contacto
  `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 	-- Fecha en que el usuario se convierte en anfitrión
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE -- FK con tabla usuarios
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------------------------------------------------------------------

--
-- Tabla de `alojamientos`
--

CREATE DATABASE alojamientos_app;
USE alojamientos_app;

CREATE TABLE `alojamientos` (
  `id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,	-- ID de alojamiento
  `id_anfitrion` int(10) NOT NULL,					-- Campo ID anfitrion para FK
  `nombre` VARCHAR(100) NOT NULL,					-- Nombre de alojamiento
  `descripcion` TEXT NOT NULL,				 		-- Descripcion de alojamiento
  `direccion` VARCHAR(255) NOT NULL,				-- Direccion de alojamiento
  `precio` DECIMAL(10,2) NOT NULL,					-- Precio de alojamiento
  `imagen` VARCHAR(255) DEFAULT NULL,				-- Guarda la URL de la imagen en el sistema
  `minpersona` INT(10) NOT NULL,					-- Min personas por alojamiento
  `maxpersona` INT(10) NOT NULL,					-- Max personas por alojamiento
  `departamento` VARCHAR(100) NOT NULL,				-- Ubicacion departamental
  `eliminado` BOOLEAN NOT NULL DEFAULT FALSE, 		-- Manejo de SOFT DELETE para eliminar alojamientos
  FOREIGN KEY (`id_anfitrion`) REFERENCES `anfitriones` (`id`) ON DELETE CASCADE  -- FK de anfitriones
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 5;

--
-- Alojamientos de ejemplo agregados
--

INSERT INTO `alojamientos` (`id`, `nombre`, `descripcion`, `direccion`, `precio`, `imagen`, `minpersona`, `maxpersona`, `departamento`) VALUES
(1, 'Hotel Paradise', 'Un hotel de lujo con todas las comodidades modernas.', 'Avenida Siempre Viva 123', 120.50, '/Alojamientos_app_PHP/public/uploads/hotel-paradaise.jpg', '3', '10', 'la libertad'),
(2, 'Hostal Aurora', 'Alojamiento económico con excelente ubicación.', 'Calle Estrella 45', 30.00, '/Alojamientos_app_PHP/public/uploads/hotel-aurora.jpg', '2', '8', 'la paz'),
(3, 'Casa de Playa', 'Casa privada frente al mar, ideal para vacaciones familiares.', 'Carretera costera KM 12', 250.00, '/Alojamientos_app_PHP/public/uploads/casa-playa.jpg', '2', '15', 'sonsonate'),
(4, 'Casa de campo', 'Casa en un ambiente primaveral para disfrutar lo hermoso de la naturaleza.', 'ciudad vieja, casa de campo, suchitoto', 175.00, '/Alojamientos_app_PHP/public/uploads/casa-campo.jpg', '1', '10', 'suchitoto');

-- ----------------------------------------------------------------------------------------

--
-- Tabla de relacion `clientes_alojamientos` que gestiona los alojamientos favoritos almacenados por usuario
--

CREATE TABLE `clientes_alojamientos` (
  `id_usuario` INT(11) NOT NULL,    										-- Campo de ID de usuario
  `id_alojamiento` INT(11) NOT NULL,										-- Campo de ID alojamiento
  PRIMARY KEY (`usuario_id`,`alojamiento_id`),  							-- PK compuesta para ambos campos
  FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,		 -- FK con tabla `usuarios`
  FOREIGN KEY (`alojamiento_id`) REFERENCES `alojamientos` (`id`) ON DELETE CASCADE, -- FK con tabla `alojamientos`
  KEY `alojamiento_id` (`alojamiento_id`)											 -- Index para la optimizacion en operaciones
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Usuario administrador agregado
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `correo`, `contrasenia`, `rol`) VALUES
(1, 'admin', 'principal', 'admin@example.com', '$2y$10$xRzb4c5nePa5fCAmP2ltguUyT.2dCOXLPJIRdrwQAZ6sm6LJzJILC', 'admin');

-- --------------------------------------------------------

--
-- Tabla de reservaciones
-- 

CREATE TABLE `reservaciones` (
	`id` int(10) NOT NULL PRIMARY KEY AUTO_INCREMENT,	-- ID de reservaciones
    `id_usuario` int(10) NOT NULL,						-- Campo ID usuario para FK
    `id_anfitrion` int(10) NOT NULL,					-- Campo ID anfitrion para FK
    `id_alojamiento` int(10) NOT NULL,					-- Campo ID usuario para FK
	`huéspedes` INT(10) NOT NULL,						-- Numero de huespedes en la reservacion
    `fecha_entrada` DATE NOT NULL,						-- Fecha de llegada al alojamiento
    `fecha_salida` DATE NOT NULL,						-- Fecha de salida del alojamiento
    `precio_noche` DECIMAL(10,2) NOT NULL,				-- Registro del precio por noche del alojamiento
    `metodo_pago` VARCHAR(50) NOT NULL,					-- Metodo de pago a usar
    `total_pago` DECIMAL(10,2) NOT NULL,				-- Total de pago calculado segun los dias a quedarse
    `estado` ENUM('pendiente','confirmada','cancelada','completada'), 	-- Estado de una reservacion
    `calificacion_usuario` TINYINT NULL, 								-- Calificación del huésped al alojamiento (1-5)
	`calificacion_anfitrion` TINYINT NULL, 								-- Calificación del anfitrión al huésped (1-5)
    `comentario_usuario` TEXT NULL, 									-- Comentario del usuario sobre el alojamiento
	`comentario_anfitrion` TEXT NULL, 									-- Comentario del anfitrión sobre el huésped
    `fecha_reservacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP				-- Fecha en la que se crea la reservacion
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 1;

-- ----------------------------------------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
