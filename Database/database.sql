CREATE DATABASE Gestion_turnos_guias_bd;

ALTER DATABASE Gestion_turnos_guias_bd
 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE Gestion_turnos_guias_bd;
SELECT CONCAT('ALTER TABLE ', TABLE_NAME, ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;')
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'Gestion_turnos_guias_bd';

use Gestion_turnos_guias_bd;

CREATE TABLE Usuarios (
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    email VARCHAR(70) UNIQUE NOT NULL,
    password VARCHAR(100) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
	estado VARCHAR(100) DEFAULT 'ACTIVO',
    rol_id INT NOT NULL,
    guia_o_supervisor_id VARCHAR(20),
    validation_token VARCHAR(250) UNIQUE,
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT
) engine = innodb;

CREATE TABLE Rols (
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombre VARCHAR(20) NOT NULL UNIQUE,
    descripcion TEXT,
    icono VARCHAR(25),
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT
) engine = innodb;

CREATE TABLE Guias (
	cedula VARCHAR(20) PRIMARY KEY NOT NULL,
    rnt VARCHAR(40) NOT NULL UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE,
    genero VARCHAR(100),
    telefono VARCHAR(15),
    foto VARCHAR(200) UNIQUE,
    observaciones TEXT,
    usuario_id INT NOT NULL,
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT
) engine = innodb;

CREATE TABLE Supervisors (
	cedula VARCHAR(20) PRIMARY KEY NOT NULL,
    rnt VARCHAR(40) NOT NULL UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE,
    genero VARCHAR(100),
    telefono VARCHAR(15),
    foto VARCHAR(200) UNIQUE,
    observaciones TEXT,
    usuario_id INT NOT NULL,
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT
) engine = innodb;

CREATE TABLE Buques (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    codigo VARCHAR(30) UNIQUE,
	nombre VARCHAR(100) NOT NULL,
    foto VARCHAR(15) UNIQUE,
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT
) engine = innodb;

CREATE TABLE Recaladas (
	id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    fecha_arribo DATETIME NOT NULL,
    fecha_zarpe DATETIME ,
    total_turistas INTEGER(5) NOT NULL,
    observaciones TEXT,
    buque_id INT NOT NULL,
    pais_id INT NOT NULL,
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT
) engine = innodb;

CREATE TABLE Pais (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	nombre VARCHAR(100) UNIQUE NOT NULL,
    bandera VARCHAR(15) UNIQUE,
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT
) engine = innodb;


CREATE TABLE Atencions (
	id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    fecha_inicio DATETIME NOT NULL,
    fecha_cierre  DATETIME,
    total_turnos INTEGER(3) NOT NULL,
    observaciones TEXT,
    supervisor_id VARCHAR(20),
    recalada_id INT NOT NULL,
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT
) engine = innodb;


CREATE TABLE turnos (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    numero int(4) NOT NULL,
    estado varchar(30) DEFAULT NULL,
    fecha_uso datetime DEFAULT NULL,
    usuario_uso INT,
    fecha_salida datetime DEFAULT NULL,
    usuario_salida INT,
    fecha_regreso datetime DEFAULT NULL,
    usuario_regreso INT,
    observaciones text,
    guia_id varchar(20) NOT NULL,
    atencion_id int NOT NULL,
    fecha_registro datetime NOT NULL,
    usuario_registro int DEFAULT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS User_tokens (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL,
    usuario_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    creado_el TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    expira_el TIMESTAMP NULL
) ENGINE=InnoDB;

ALTER TABLE Usuarios
ADD CONSTRAINT Fk_Rols_usuarios
FOREIGN KEY (rol_id)
REFERENCES Rols(id);

ALTER TABLE Supervisors
ADD CONSTRAINT Fk_Usuarios_Supervisors
FOREIGN KEY (usuario_id)
REFERENCES Usuarios(id);

ALTER TABLE Guias
ADD CONSTRAINT Fk_Usuarios_Guias
FOREIGN KEY (usuario_id)
REFERENCES Usuarios(id);

ALTER TABLE Recaladas
ADD CONSTRAINT Fk_Recaladas_Buques
FOREIGN KEY (buque_id)
REFERENCES Buques(id);

ALTER TABLE Recaladas
ADD CONSTRAINT Fk_Paises_Recalada
FOREIGN KEY (pais_id)
REFERENCES Pais(id);

ALTER TABLE Atencions
ADD CONSTRAINT Fk_Atenciones_Recaladas
FOREIGN KEY (recalada_id)
REFERENCES Recaladas(id);

ALTER TABLE Atencions
ADD CONSTRAINT Fk_Supervisors_Atencions
FOREIGN KEY (supervisor_id)
REFERENCES Supervisors(cedula);

ALTER TABLE Turnos
ADD CONSTRAINT Fk_Turnos_Atenciones
FOREIGN KEY (atencion_id)
REFERENCES Atencions(id);

ALTER TABLE Turnos
ADD CONSTRAINT Fk_Guias_Turnos
FOREIGN KEY (guia_id)
REFERENCES Guias(cedula);

ALTER TABLE User_tokens
ADD CONSTRAINT Fk_UserTokens_Usuarios
FOREIGN KEY (usuario_id)
REFERENCES Usuarios(id);

INSERT INTO `rols` (`id`, `nombre`, `descripcion`, `icono`, `fecha_registro`, `usuario_registro`) VALUES
	(1, 'Super Usuario', 'Persona puede crear, actualizar, eliminar, autorizar usuarios, crear roles, crear y otras funciones', NULL, '2024-06-19 19:57:06', 1),
	(2, 'Supervisor', 'Persona que puede supervisar las atenciones y el uso de turnos de guias en una recalada', NULL, '2024-06-19 20:01:58', 1),
	(3, 'Guia', 'Persona que puede supervisar las atenciones y el uso de turnos de guias en una recalada', NULL, '2024-06-19 20:01:58', 1),
	(4, 'Usuario', 'Persona toma y usa turnos para atender a turistas de una recalada', NULL, '2024-06-19 20:04:23', 1);

INSERT INTO pais (nombre, bandera, fecha_registro, usuario_registro) VALUES
('Afganistán', 'AF', NOW(), 1),
('Albania', 'AL', NOW(), 1),
('Alemania', 'DE', NOW(), 1),
('Andorra', 'AD', NOW(), 1),
('Angola', 'AO', NOW(), 1),
('Antigua y Barbuda', 'AG', NOW(), 1),
('Arabia Saudita', 'SA', NOW(), 1),
('Argelia', 'DZ', NOW(), 1),
('Argentina', 'AR', NOW(), 1),
('Armenia', 'AM', NOW(), 1),
('Australia', 'AU', NOW(), 1),
('Austria', 'AT', NOW(), 1),
('Azerbaiyán', 'AZ', NOW(), 1),
('Bahamas', 'BS', NOW(), 1),
('Bangladesh', 'BD', NOW(), 1),
('Barbados', 'BB', NOW(), 1),
('Baréin', 'BH', NOW(), 1),
('Bélgica', 'BE', NOW(), 1),
('Belice', 'BZ', NOW(), 1),
('Benín', 'BJ', NOW(), 1),
('Bielorrusia', 'BY', NOW(), 1),
('Birmania', 'MM', NOW(), 1),
('Bolivia', 'BO', NOW(), 1),
('Bosnia y Herzegovina', 'BA', NOW(), 1),
('Botsuana', 'BW', NOW(), 1),
('Brasil', 'BR', NOW(), 1),
('Brunéi', 'BN', NOW(), 1),
('Bulgaria', 'BG', NOW(), 1),
('Burkina Faso', 'BF', NOW(), 1),
('Burundi', 'BI', NOW(), 1),
('Bután', 'BT', NOW(), 1),
('Cabo Verde', 'CV', NOW(), 1),
('Camboya', 'KH', NOW(), 1),
('Camerún', 'CM', NOW(), 1),
('Canadá', 'CA', NOW(), 1),
('Catar', 'QA', NOW(), 1),
('Chad', 'TD', NOW(), 1),
('Chile', 'CL', NOW(), 1),
('China', 'CN', NOW(), 1),
('Chipre', 'CY', NOW(), 1),
('Colombia', 'CO', NOW(), 1),
('Comoras', 'KM', NOW(), 1),
('Corea del Norte', 'KP', NOW(), 1),
('Corea del Sur', 'KR', NOW(), 1),
('Costa de Marfil', 'CI', NOW(), 1),
('Costa Rica', 'CR', NOW(), 1),
('Croacia', 'HR', NOW(), 1),
('Cuba', 'CU', NOW(), 1),
('Dinamarca', 'DK', NOW(), 1),
('Dominica', 'DM', NOW(), 1),
('Ecuador', 'EC', NOW(), 1),
('Egipto', 'EG', NOW(), 1),
('El Salvador', 'SV', NOW(), 1),
('Emiratos Árabes Unidos', 'AE', NOW(), 1),
('Eritrea', 'ER', NOW(), 1),
('Eslovaquia', 'SK', NOW(), 1),
('Eslovenia', 'SI', NOW(), 1),
('España', 'ES', NOW(), 1),
('Estados Unidos', 'US', NOW(), 1),
('Estonia', 'EE', NOW(), 1),
('Etiopía', 'ET', NOW(), 1),
('Filipinas', 'PH', NOW(), 1),
('Finlandia', 'FI', NOW(), 1),
('Fiyi', 'FJ', NOW(), 1),
('Francia', 'FR', NOW(), 1),
('Gabón', 'GA', NOW(), 1),
('Gambia', 'GM', NOW(), 1),
('Georgia', 'GE', NOW(), 1),
('Ghana', 'GH', NOW(), 1),
('Granada', 'GD', NOW(), 1),
('Grecia', 'GR', NOW(), 1),
('Guatemala', 'GT', NOW(), 1),
('Guinea', 'GN', NOW(), 1),
('Guinea-Bisáu', 'GW', NOW(), 1),
('Guinea Ecuatorial', 'GQ', NOW(), 1),
('Guyana', 'GY', NOW(), 1),
('Haití', 'HT', NOW(), 1),
('Honduras', 'HN', NOW(), 1),
('Hungría', 'HU', NOW(), 1),
('India', 'IN', NOW(), 1),
('Indonesia', 'ID', NOW(), 1),
('Irak', 'IQ', NOW(), 1),
('Irán', 'IR', NOW(), 1),
('Irlanda', 'IE', NOW(), 1),
('Islandia', 'IS', NOW(), 1),
('Islas Marshall', 'MH', NOW(), 1),
('Islas Salomón', 'SB', NOW(), 1),
('Israel', 'IL', NOW(), 1),
('Italia', 'IT', NOW(), 1),
('Jamaica', 'JM', NOW(), 1),
('Japón', 'JP', NOW(), 1),
('Jordania', 'JO', NOW(), 1),
('Kazajistán', 'KZ', NOW(), 1),
('Kenia', 'KE', NOW(), 1),
('Kirguistán', 'KG', NOW(), 1),
('Kiribati', 'KI', NOW(), 1),
('Kuwait', 'KW', NOW(), 1),
('Kosovo', 'XK', NOW(), 1),
('Laos', 'LA', NOW(), 1),
('Lesoto', 'LS', NOW(), 1),
('Letonia', 'LV', NOW(), 1),
('Líbano', 'LB', NOW(), 1),
('Liberia', 'LR', NOW(), 1),
('Libia', 'LY', NOW(), 1),
('Liechtenstein', 'LI', NOW(), 1),
('Lituania', 'LT', NOW(), 1),
('Luxemburgo', 'LU', NOW(), 1),
('Madagascar', 'MG', NOW(), 1),
('Malasia', 'MY', NOW(), 1),
('Malaui', 'MW', NOW(), 1),
('Maldivas', 'MV', NOW(), 1),
('Malí', 'ML', NOW(), 1),
('Malta', 'MT', NOW(), 1),
('Marruecos', 'MA', NOW(), 1),
('Mauricio', 'MU', NOW(), 1),
('Mauritania', 'MR', NOW(), 1),
('México', 'MX', NOW(), 1),
('Micronesia', 'FM', NOW(), 1),
('Moldavia', 'MD', NOW(), 1),
('Mónaco', 'MC', NOW(), 1),
('Mongolia', 'MN', NOW(), 1),
('Montenegro', 'ME', NOW(), 1),
('Mozambique', 'MZ', NOW(), 1),
('Namibia', 'NA', NOW(), 1),
('Nauru', 'NR', NOW(), 1),
('Nepal', 'NP', NOW(), 1),
('Nicaragua', 'NI', NOW(), 1),
('Níger', 'NE', NOW(), 1),
('Nigeria', 'NG', NOW(), 1),
('Noruega', 'NO', NOW(), 1),
('Nueva Zelanda', 'NZ', NOW(), 1),
('Omán', 'OM', NOW(), 1),
('Países Bajos', 'NL', NOW(), 1),
('Pakistán', 'PK', NOW(), 1),
('Palaos', 'PW', NOW(), 1),
('Palestina', 'PS', NOW(), 1),
('Panamá', 'PA', NOW(), 1),
('Papúa Nueva Guinea', 'PG', NOW(), 1),
('Paraguay', 'PY', NOW(), 1),
('Perú', 'PE', NOW(), 1),
('Polonia', 'PL', NOW(), 1),
('Portugal', 'PT', NOW(), 1),
('Reino Unido', 'GB', NOW(), 1),
('República Centroafricana', 'CF', NOW(), 1),
('República Checa', 'CZ', NOW(), 1),
('República del Congo', 'CG', NOW(), 1),
('República Democrática del Congo', 'CD', NOW(), 1),
('República Dominicana', 'DO', NOW(), 1),
('Ruanda', 'RW', NOW(), 1),
('Rumania', 'RO', NOW(), 1),
('Rusia', 'RU', NOW(), 1),
('Samoa', 'WS', NOW(), 1),
('San Cristóbal y Nieves', 'KN', NOW(), 1),
('San Marino', 'SM', NOW(), 1),
('San Vicente y las Granadinas', 'VC', NOW(), 1),
('Santa Lucía', 'LC', NOW(), 1),
('Santo Tomé y Príncipe', 'ST', NOW(), 1),
('Senegal', 'SN', NOW(), 1),
('Serbia', 'RS', NOW(), 1),
('Seychelles', 'SC', NOW(), 1),
('Sierra Leona', 'SL', NOW(), 1),
('Singapur', 'SG', NOW(), 1),
('Siria', 'SY', NOW(), 1),
('Somalia', 'SO', NOW(), 1),
('Sri Lanka', 'LK', NOW(), 1),
('Suazilandia (Esuatini)', 'SZ', NOW(), 1),
('Sudáfrica', 'ZA', NOW(), 1),
('Sudán', 'SD', NOW(), 1),
('Sudán del Sur', 'SS', NOW(), 1),
('Suecia', 'SE', NOW(), 1),
('Suiza', 'CH', NOW(), 1),
('Surinam', 'SR', NOW(), 1),
('Tailandia', 'TH', NOW(), 1),
('Tanzania', 'TZ', NOW(), 1),
('Tayikistán', 'TJ', NOW(), 1),
('Timor Oriental', 'TL', NOW(), 1),
('Togo', 'TG', NOW(), 1),
('Tonga', 'TO', NOW(), 1),
('Trinidad y Tobago', 'TT', NOW(), 1),
('Túnez', 'TN', NOW(), 1),
('Turkmenistán', 'TM', NOW(), 1),
('Turquía', 'TR', NOW(), 1),
('Tuvalu', 'TV', NOW(), 1),
('Ucrania', 'UA', NOW(), 1),
('Uganda', 'UG', NOW(), 1),
('Uruguay', 'UY', NOW(), 1),
('Uzbekistán', 'UZ', NOW(), 1),
('Vaticano', 'VA', NOW(), 1),
('Vanuatu', 'VU', NOW(), 1),
('Venezuela', 'VE', NOW(), 1),
('Vietnam', 'VN', NOW(), 1),
('Yemen', 'YE', NOW(), 1),
('Yibuti', 'DJ', NOW(), 1),
('Zambia', 'ZM', NOW(), 1),
('Zimbabue', 'ZW', NOW(), 1);

-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.1.72-community - MySQL Community Server (GPL)
-- SO del servidor:              Win32
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

INSERT INTO `usuarios` (`id`, `email`, `password`, `nombre`, `estado`, `rol_id`, `guia_o_supervisor_id`, `validation_token`, `fecha_registro`, `usuario_registro`)
 VALUES (1, 'guiasturadmin@yopmail.com', 'Abc123$$', 'John Arrieta', 'Activado', 1, NULL, NULL, '2024-07-17 17:07:27', 1);
