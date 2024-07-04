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
    fecha_zarpe DATE,
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

