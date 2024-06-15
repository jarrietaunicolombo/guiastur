CREATE DATABASE Gestion_turnos_guias_bd;

ALTER DATABASE Gestion_turnos_guias_bd
 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE nombre_base_de_datos;
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
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT 
) engine = innodb;


CREATE TABLE Roles (
	id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nombre VARCHAR(20) NOT NULL,
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
    foto VARCHAR(200) UNIQUE,
    observaciones TEXT,
    usuario_id INT NOT NULL,
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT 
) engine = innodb;

CREATE TABLE Supervisores (
	cedula VARCHAR(20) PRIMARY KEY NOT NULL,
    rnt VARCHAR(40) NOT NULL UNIQUE,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    fecha_nacimiento DATE,
    genero VARCHAR(100),
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
    fecha_zarpe DATE,
    total_turistas INTEGER(5) NOT NULL,
    observaciones TEXT,
    buque_id INT NOT NULL,
    pais_origen INT NOT NULL,
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT
) engine = innodb;


CREATE TABLE Paises (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	nombre VARCHAR(100) UNIQUE NOT NULL,
    bandera VARCHAR(15) UNIQUE,
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT 
) engine = innodb;


CREATE TABLE Atenciones (
	id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    fecha_inicio DATETIME NOT NULL,
    fecha_cierre  DATETIME,
    total_turnos INTEGER(3) NOT NULL,
    observaciones TEXT,
    supervisor_id INT,
    recalada_id INT NOT NULL,
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT 
) engine = innodb;



CREATE TABLE Turnos (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
	numero INTEGER(4) NOT NULL,
    observaciones VARCHAR(100) ,
    estado VARCHAR(30),
	guia_id INT NOT NULL,
    atencion_id INT NOT NULL,
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT 
) engine = innodb;


CREATE TABLE Gestion_turnos (
    turno_id INT NOT NULL,
    guia_id INT NOT NULL,
    fecha_uso DATETIME NOT NULL,
    fecha_salida DATETIME,
    fecha_regreso DATETIME,
    observaciones TEXT,
    fecha_registro DATETIME NOT NULL,
    usuario_registro INT,
    PRIMARY KEY(turno_id, guia_id)
) engine = innodb;


ALTER TABLE Usuarios
ADD CONSTRAINT Fk_Roles_usuarios
FOREIGN KEY (rol_id)
REFERENCES Roles(id);

ALTER TABLE Supervisores
ADD CONSTRAINT Fk_Usuarios_Supervisores
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
FOREIGN KEY (pais_origen)
REFERENCES Paises(id);

ALTER TABLE Atenciones
ADD CONSTRAINT Fk_Atenciones_Recaladas
FOREIGN KEY (recalada_id)
REFERENCES Recaladas(id);

ALTER TABLE Atenciones
ADD CONSTRAINT Fk_Supervisores_Atenciones
FOREIGN KEY (supervisor_id)
REFERENCES Supervisores(cedula);

ALTER TABLE Turnos
ADD CONSTRAINT Fk_Turnos_Atenciones
FOREIGN KEY (atencion_id)
REFERENCES Atenciones(id);

ALTER TABLE Turnos
ADD CONSTRAINT Fk_Guias_Turnos
FOREIGN KEY (guia_id)
REFERENCES Guias(cedula);

ALTER TABLE Gestion_turnos
ADD CONSTRAINT Fk_Gestion_turnos_Guias
FOREIGN KEY (guia_id)
REFERENCES Guias(cedula);

ALTER TABLE Gestion_turnos
ADD CONSTRAINT Fk_Gestion_turnos_Turnos
FOREIGN KEY (turno_id)
REFERENCES Turnos(id);

