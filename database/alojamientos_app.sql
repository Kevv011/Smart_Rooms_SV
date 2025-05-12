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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 1;

--
-- Usuarios agregados
--

INSERT INTO `usuarios` (`nombre`, `apellido`, `telefono`, `correo`, `contrasenia`, `rol`) VALUES
('rolando enrique', 'lopez', '+503 76546328', 'rolandolopez@gmail.com', '$2y$10$L1GFxX2U0bzRyVbYv.msoO.Eg2yy/T2u8aGZCphLxedSi2v/objsu', 'administrador'), -- pass: rolandolopez
('rosa maria', 'galdamez giron', '+503 67890045', 'rosagaldamez@gmail.com', '$2y$10$9IihuLmbutHSFw/ELNjXke0Kyzll3iMfzB4UQNYInbfjEuTcfTP7u', 'anfitrion'), -- pass: rosagaldamez
('carlos eduardo', 'perez', '+503 78928569', 'carlosperez@gmail.com', '$2y$10$eF8POiF81SP7rlFNGLnPT.0BHC66c/nF4uzmevdaMmj3c3z1JDSYq', 'empleado'),	      -- pass: carlosperez
('ana sofía', 'menéndez', '+503 70123456', 'ana.menendez@gmail.com', '$2y$10$9H3q6GlfZqu10tKFoP0eHuK3CI1eEHoIYFl7Bq8Zblp65nlrLnvya', 'anfitrion'),        -- pass: 123456
('mario ernesto', 'beltrán', '+503 74561238', 'mario.beltran@gmail.com', '$2y$10$9H3q6GlfZqu10tKFoP0eHuK3CI1eEHoIYFl7Bq8Zblp65nlrLnvya', 'anfitrion'),    -- pass: 123456
('claudia patricia', 'ibarra', '+503 79204561', 'claudia.ibarra@gmail.com', '$2y$10$9H3q6GlfZqu10tKFoP0eHuK3CI1eEHoIYFl7Bq8Zblp65nlrLnvya', 'anfitrion'), -- pass: 123456
('jorge luis', 'castro', '+503 70112233', 'jorge.castro@gmail.com', '$2y$10$9H3q6GlfZqu10tKFoP0eHuK3CI1eEHoIYFl7Bq8Zblp65nlrLnvya', 'anfitrion'),		  -- pass: 123456
('diana maría', 'flores', '+503 79881234', 'diana.flores@gmail.com', '$2y$10$9H3q6GlfZqu10tKFoP0eHuK3CI1eEHoIYFl7Bq8Zblp65nlrLnvya', 'empleado'),		  -- pass: 123456
('kevin alejandro', 'lemus', '+503 78451239', 'kevin.lemus@gmail.com', '$2y$10$9H3q6GlfZqu10tKFoP0eHuK3CI1eEHoIYFl7Bq8Zblp65nlrLnvya', 'empleado'),       -- pass: 123456
('alejandra', 'guzmán', '+503 70001122', 'alejandra.guzman@gmail.com', '$2y$10$9H3q6GlfZqu10tKFoP0eHuK3CI1eEHoIYFl7Bq8Zblp65nlrLnvya', 'empleado'),       -- pass: 123456
('ricardo', 'torres', '+503 70223344', 'ricardo.torres@gmail.com', '$2y$10$9H3q6GlfZqu10tKFoP0eHuK3CI1eEHoIYFl7Bq8Zblp65nlrLnvya', 'empleado'),           -- pass: 123456
('paola', 'herrera', '+503 72334455', 'paola.herrera@gmail.com', '$2y$10$9H3q6GlfZqu10tKFoP0eHuK3CI1eEHoIYFl7Bq8Zblp65nlrLnvya', 'empleado');             -- pass: 123456

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 1;

--
-- Anfitriones agregados
--

INSERT INTO `anfitriones` (`id_usuario`,`biografia`) VALUES 
(2, 'anfitrión dueño de diversos ranchos en el area de la libertad'),
(4, 'Apasionada por la hospitalidad rural en Ahuachapán'),
(5, 'Arquitecto y propietario de cabañas ecológicas'),
(6, 'Emprendedora con experiencia en turismo de montaña'),
(7, 'Dueño de propiedades en la zona costera');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 1;

--
-- Empleados agregados
--

INSERT INTO `empleados` (`id_usuario`,`cargo`) VALUES
(3, 'Administrador de reservaciones'),
(8, 'Soporte de reservaciones'),
(9, 'Coordinador de limpieza'),
(10, 'Encargada de atención al cliente'),
(11, 'Técnico de mantenimiento'),
(12, 'Asistente administrativo');
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
  `latitud` DECIMAL(10, 8), 						-- Valor de latitud (Ubicacion con mapa)
  `longitud` DECIMAL(11, 8),						-- Valor de longitud (Ubicacion con mapa)
  `estado_reservado` BOOLEAN NOT NULL DEFAULT TRUE, -- Denota si esta reservado o no el alojamiento
  `eliminado` BOOLEAN NOT NULL DEFAULT FALSE, 		-- Manejo de SOFT DELETE para eliminar alojamientos
  `fecha_registro` TIMESTAMP DEFAULT CURRENT_TIMESTAMP, 		  					-- Fecha en que se crea el alojamiento
  `actualizado_en` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,	-- Registra fecha y hora de actualizaciones de un alojamiento
  FOREIGN KEY (`id_anfitrion`) REFERENCES `anfitriones` (`id`) ON DELETE CASCADE  -- FK de anfitriones
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci AUTO_INCREMENT = 1;
--
-- Alojamientos agregados
--

INSERT INTO alojamientos (
    id_anfitrion, nombre, descripcion, direccion, precio, imagen,
    minpersona, maxpersona, mascota, departamento, latitud, longitud, eliminado
) VALUES
-- Alojamiento 1
(1, 'Cabaña El Roble', 'Hermosa cabaña rodeada de naturaleza con vistas al bosque.', 
 'Km 5 Carretera a la montaña, La Palma', 85.00, '/public/uploads/1_cabana_roble.jpg', 
 2, 4, TRUE, 'Chalatenango', 14.358408, -89.121962, FALSE),

-- Alojamiento 2
(3, 'Casa Colonial Centro', 'Alojamiento colonial con todas las comodidades en el corazón de la ciudad.', 
 'Av. Independencia #123, San Salvador', 120.00, '/public/uploads/2_casa_colonial.jpg', 
 2, 6, FALSE, 'San Salvador', 13.703948, -89.244869, FALSE),

-- Alojamiento 3
(5, 'Apartamento Costa del Sol', 'Moderno apartamento frente al mar ideal para vacaciones familiares.', 
 'Boulevard Costa del Sol, La Paz', 150.00, '/public/uploads/3_apartamento_costa.jpg', 
 4, 8, TRUE, 'La Paz', 13.343622, -89.005948, FALSE),

-- Alojamiento 4
(2, 'Glamping El Encanto', 'Experiencia de camping de lujo con todas las comodidades.', 
 'Ruta hacia Apaneca, Ahuachapán', 95.50, '/public/uploads/4_glamping.jpg', 
 2, 3, TRUE, 'Ahuachapán', 13.688860, -89.999827, FALSE),
 
 -- Alojamiento 5
(4, 'Residencial Sierra Verde', 'Casa moderna en zona tranquila, ideal para familias o estancias largas.', 
 'Residencial Sierra Verde, Antiguo Cuscatlán', 110.00, '/public/uploads/5_sierra-verde.jpg', 
 2, 5, FALSE, 'La Libertad', 13.673421, -89.251678, FALSE),

-- Alojamiento 6
(4, 'Casa Tuscania', 'Alojamiento exclusivo en residencial privado con seguridad 24/7 y áreas verdes.', 
 'Residencial Tuscania, Nuevo Cuscatlán', 130.00, '/public/uploads/6_tuscania.jpg', 
 2, 6, FALSE, 'La Libertad', 13.652489, -89.287316, FALSE),

-- Alojamiento 7
(2, 'Villa San Diego', 'Amplia casa frente al mar con piscina privada y acceso directo a la playa.', 
 'Playa San Diego, La Libertad', 160.00, '/public/uploads/7_playa_san_diego.jpg', 
 4, 10, TRUE, 'La Libertad', 13.479932, -89.384139, FALSE),

-- Alojamiento 8
(3, 'Apartamento Miramonte', 'Cómodo apartamento urbano con acceso a centros comerciales y transporte.', 
 'Calle Los Sisimiles, Colonia Miramonte, San Salvador', 90.00, '/public/uploads/8_miramonte.jpeg', 
 1, 3, FALSE, 'San Salvador', 13.703214, -89.229987, FALSE);

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