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
CREATE DATABASE alojamientos_app;
USE alojamientos_app;
-- ----------------------------------------------------------------------------------------

--
-- Tabla de `usuarios`
--

CREATE TABLE `usuarios` (
  `id` INT(10) PRIMARY KEY AUTO_INCREMENT,			-- ID de la tabla usuarios
  `nombre` VARCHAR(100) NOT NULL,					-- Nombre usuario
  `apellido` VARCHAR(100) NULL,						-- Apellido usuario
  `telefono` VARCHAR(20) NULL, 						-- Teléfono de contacto
  `correo` VARCHAR(100) NOT NULL UNIQUE,			-- Correo de usuario
  `contrasenia` VARCHAR(255) NOT NULL,				-- Contraseña usuario
  `rol` ENUM('administrador','empleado', 'cliente', 'anfitrion'), -- Rol por usuario
  `estado` ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo',  		   			-- Estado del usuario
  `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 		  					-- Fecha en que se crea al usuario
  `actualizado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP	-- Registra fecha y hora de actualizaciones de un usuario
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 2;

--
-- Usuarios agregados
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `telefono`, `correo`, `contrasenia`, `rol`) VALUES
(1, 'rolando enrique', 'lopez', '+503 7654-6328', 'rolandolopez@gmail.com', '$2y$10$L1GFxX2U0bzRyVbYv.msoO.Eg2yy/T2u8aGZCphLxedSi2v/objsu', 'administrador'), 	 -- pass: rolandolopez
(2, 'rosa maria', 'galdamez giron', '+503 6789-0045', 'rosagaldamez@gmail.com', '$2y$10$9IihuLmbutHSFw/ELNjXke0Kyzll3iMfzB4UQNYInbfjEuTcfTP7u', 'anfitrion'), -- pass: rosagaldamez
(3, 'carlos eduardo', 'perez', '+503 7892-8569', 'carlosperez@gmail.com', '$2y$10$eF8POiF81SP7rlFNGLnPT.0BHC66c/nF4uzmevdaMmj3c3z1JDSYq', 'empleado');	     -- pass: carlosperez

-- ----------------------------------------------------------------------------------------

--
-- Tabla de anfitriones de alojamientos
-- 

CREATE TABLE `anfitriones` (
  `id` INT(10) PRIMARY KEY AUTO_INCREMENT,					-- Campo ID anfitrion
  `id_usuario` INT(10) NOT NULL,                            -- Campo ID usuario para FK
  `biografia` TEXT NULL, 									-- Descripción breve del anfitrion
  `actualizado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Registra fecha y hora de actualizaciones de un anfitrion
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE 			-- FK con tabla usuarios
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 2;

--
-- Anfitriones agregados
--

INSERT INTO `anfitriones` (`id`,`id_usuario`,`biografia`) VALUES 
(1, 2, 'anfitrión dueño de diversos ranchos en el area de la libertad');

-- ----------------------------------------------------------------------------------------

--
-- Tabla de empleados 
-- 

CREATE TABLE `empleados` (
  `id` INT(10) PRIMARY KEY AUTO_INCREMENT,					-- Campo ID empleado
  `id_usuario` INT(10) NOT NULL, 					-- Campo ID usuario para FK
  `fecha_nacimiento`DATE NULL,              				-- Fecha de nacimiento
  `fecha_contratacion` DATE NOT NULL,						-- Fecha de ingreso a la empresa
  `direccion` VARCHAR(255) NULL,							-- Direccion de residencia del empleado
  `cargo` VARCHAR(100) NOT NULL, 							-- cargo en la empresa 
  `salario` DECIMAL(10,2) NOT NULL,                         -- Salario del empleado
  `actualizado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Registra fecha y hora de actualizaciones de un empleado
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE 			-- FK con tabla usuarios
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 2;

--
-- Empleados registrados
--

INSERT INTO empleados (id, id_usuario, fecha_nacimiento, fecha_contratacion, direccion, cargo, salario)  
VALUES (1, 3, '1990-06-15', '2023-01-10', 'Avenida Central #123, San Salvador', 'encargado de operaciones', 750.00);

-- ----------------------------------------------------------------------------------------

--
-- Tabla de `alojamientos`
--

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
  `mascota` BOOLEAN NOT NULL DEFAULT FALSE,         -- Muestra si es permitido mascotas en el alojamiento
  `departamento` VARCHAR(100) NOT NULL,				-- Ubicacion departamental
  `eliminado` BOOLEAN NOT NULL DEFAULT FALSE, 		-- Manejo de SOFT DELETE para eliminar alojamientos
  `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 		  					-- Fecha en que se crea el alojamiento
  `actualizado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,	-- Registra fecha y hora de actualizaciones de un alojamiento
  FOREIGN KEY (`id_anfitrion`) REFERENCES `anfitriones` (`id`) ON DELETE CASCADE  -- FK de anfitriones
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 5;

--
-- Alojamientos agregados
--

-- INSERT INTO `alojamientos` (`id`, `id_anfitrion`, `nombre`, `descripcion`, `direccion`, `precio`, `imagen`, `minpersona`, `maxpersona`, `departamento`) VALUES
-- (1, 1, 'Hotel Paradise', 'Un hotel de lujo con todas las comodidades modernas.', 'Avenida Siempre Viva 123', 120.50, '/Alojamientos_app_PHP/public/uploads/hotel-paradaise.jpg', '3', '10', 'la libertad'),
-- (2, 1, 'Hostal Aurora', 'Alojamiento económico con excelente ubicación.', 'Calle Estrella 45', 30.00, '/Alojamientos_app_PHP/public/uploads/hotel-aurora.jpg', '2', '8', 'la paz'),
-- (3, 2, 'Casa de Playa', 'Casa privada frente al mar, ideal para vacaciones familiares.', 'Carretera costera KM 12', 250.00, '/Alojamientos_app_PHP/public/uploads/casa-playa.jpg', '2', '15', 'sonsonate'),
-- (4, 2, 'Casa de campo', 'Casa en un ambiente primaveral para disfrutar lo hermoso de la naturaleza.', 'ciudad vieja, casa de campo, suchitoto', 175.00, '/Alojamientos_app_PHP/public/uploads/casa-campo.jpg', '1', '10', 'suchitoto');

-- ----------------------------------------------------------------------------------------

--
-- Tabla de relacion `clientes_alojamientos` que gestiona los alojamientos favoritos almacenados por usuario
--

CREATE TABLE `clientes_alojamientos` (
  `id_usuario` INT(11) NOT NULL,    										-- Campo de ID de usuario
  `id_alojamiento` INT(11) NOT NULL,										-- Campo de ID alojamiento
  PRIMARY KEY (`id_usuario`,`id_alojamiento`),  							-- PK compuesta para ambos campos
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,		 -- FK con tabla `usuarios`
  FOREIGN KEY (`id_alojamiento`) REFERENCES `alojamientos` (`id`) ON DELETE CASCADE, -- FK con tabla `alojamientos`
  KEY `alojamiento_id` (`id_alojamiento`)											 -- Index para la optimizacion en operaciones
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
    `metodo_pago` VARCHAR(50) NOT NULL,					-- Metodo de pago a usar
    `total_pago` DECIMAL(10,2) NOT NULL,				-- Total de pago calculado segun los dias a quedarse
    `estado` ENUM('pendiente','confirmada','cancelada','completada'), 	-- Estado de una reservacion
    `calificacion_usuario` TINYINT NULL, 								-- Calificación del huésped al alojamiento (1-5)
	`calificacion_anfitrion` TINYINT NULL, 								-- Calificación del anfitrión al huésped (1-5)
    `comentario_usuario` TEXT NULL, 									-- Comentario del usuario sobre el alojamiento
	`comentario_anfitrion` TEXT NULL, 									-- Comentario del anfitrión sobre el huésped
    `fecha_reservacion` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,			-- Fecha en la que se crea la reservacion
	`actualizado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Registra fecha y hora de actualizaciones de una reservacion
    FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,		 	-- FK con tabla `usuarios`
	FOREIGN KEY (`id_anfitrion`) REFERENCES `anfitriones` (`id`) ON DELETE CASCADE,  	-- FK de anfitriones
    FOREIGN KEY (`id_alojamiento`) REFERENCES `alojamientos` (`id`) ON DELETE CASCADE   -- FK con tabla `alojamientos`
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 1;

-- ----------------------------------------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;