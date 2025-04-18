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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 4;

--
-- Usuarios agregados
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `telefono`, `correo`, `contrasenia`, `rol`) VALUES
(1, 'rolando enrique', 'lopez', '+503 76546328', 'rolandolopez@gmail.com', '$2y$10$L1GFxX2U0bzRyVbYv.msoO.Eg2yy/T2u8aGZCphLxedSi2v/objsu', 'administrador'), 	 -- pass: rolandolopez
(2, 'rosa maria', 'galdamez giron', '+503 67890045', 'rosagaldamez@gmail.com', '$2y$10$9IihuLmbutHSFw/ELNjXke0Kyzll3iMfzB4UQNYInbfjEuTcfTP7u', 'anfitrion'), -- pass: rosagaldamez
(3, 'carlos eduardo', 'perez', '+503 78928569', 'carlosperez@gmail.com', '$2y$10$eF8POiF81SP7rlFNGLnPT.0BHC66c/nF4uzmevdaMmj3c3z1JDSYq', 'empleado');	     -- pass: carlosperez

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
  `id_usuario` INT(10) NOT NULL, 							-- Campo ID usuario para FK
  `cargo` VARCHAR(100) NOT NULL, 							-- cargo para mostrar en la plataforma
  `actualizado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- Registra fecha y hora de actualizaciones de un empleado
  FOREIGN KEY (`id_usuario`) REFERENCES `usuarios`(`id`) ON DELETE CASCADE 			-- FK con tabla usuarios
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 2;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 1;

--
-- Alojamientos agregados
--

INSERT INTO alojamientos (
    id, id_anfitrion, nombre, descripcion, direccion, precio, imagen,
    minpersona, maxpersona, mascota, departamento, eliminado
) VALUES
-- Alojamiento 1
(1, 1, 'Cabaña El Roble', 'Hermosa cabaña rodeada de naturaleza con vistas al bosque.', 'Km 5 Carretera a la montaña, La Palma', 85.00,
'/public/uploads/1_cabana_roble.jpg', 2, 4, TRUE, 'Chalatenango', FALSE),

-- Alojamiento 2
(NULL, 1, 'Casa Colonial Centro', 'Alojamiento colonial con todas las comodidades en el corazón de la ciudad.', 'Av. Independencia #123, San Salvador', 120.00,
'/public/uploads/2_casa_colonial.jpg', 2, 6, FALSE, 'San Salvador', FALSE),

-- Alojamiento 3
(NULL, 1, 'Apartamento Costa del Sol', 'Moderno apartamento frente al mar ideal para vacaciones familiares.', 'Boulevard Costa del Sol, La Paz', 150.00,
'/public/uploads/3_apartamento_costa.jpg', 4, 8, TRUE, 'La Paz', FALSE),

-- Alojamiento 4
(NULL, 1, 'Glamping El Encanto', 'Experiencia de camping de lujo con todas las comodidades.', 'Ruta hacia Apaneca, Ahuachapán', 95.50,
'/public/uploads/4_glamping.jpg', 2, 3, TRUE, 'Ahuachapán', FALSE);

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

SELECT 
    u.id AS usuario_id,
    u.nombre AS nombre_usuario,
    u.apellido,
    u.telefono,
    u.correo,
    u.rol,
    u.estado,
    u.fecha_registro AS usuario_registro,

    a.id AS anfitrion_id,
    a.biografia,
    a.actualizado_en AS anfitrion_actualizado,

    al.id AS alojamiento_id,
    al.nombre AS nombre_alojamiento,
    al.descripcion,
    al.direccion,
    al.precio,
    al.imagen,
    al.minpersona,
    al.maxpersona,
    al.mascota,
    al.departamento,
    al.eliminado,
    al.fecha_registro AS alojamiento_registro,
    al.actualizado_en AS alojamiento_actualizado

FROM alojamientos al
JOIN anfitriones a ON al.id_anfitrion = a.id
JOIN usuarios u ON a.id_usuario = u.id
WHERE al.id = 1;
