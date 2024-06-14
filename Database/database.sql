CREATE TABLE Usuarios (
	usuario_id INT PRIMARY KEY,
    nomnbre VARCHAR(100) NOT NULL,
    u_password VARCHAR(100) NOT NULL,
    rol VARCHAR(100) NOT NULL,
	estado VARCHAR(100) NOT NULL,
    fecha_reg DATE NOT NULL
)

CREATE TABLE Guias (
	cedula VARCHAR(100) PRIMARY KEY,
    rnt VARCHAR(100) NOT NULL,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    fecha_nac DATE NOT NULL,
    email VARCHAR(100) NOT NULL,
    genero VARCHAR(100) NOT NULL,
	estado VARCHAR(100) NOT NULL,
    foto VARCHAR(200) NOT NULL,
    observaciones VARCHAR(200) NOT NULL
)

CREATE TABLE Buques (
	nombre VARCHAR(100) PRIMARY KEY,
    foto VARCHAR(100) NOT NULL,
    fecha_reg DATE NOT NULL,
    usuario_id INT,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id)
)


CREATE TABLE Recaladas (
	codigo VARCHAR(100) PRIMARY KEY,
    id INT NOT NULL,
    fecha_ini DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    fecha_reg DATE NOT NULL,
    num_turistas INT(11) NOT NULL,
    observaciones VARCHAR(100) NOT NULL,
    origen VARCHAR(100) NOT NULL,
	usuario_id INT,
    nombre VARCHAR(100),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id),
    FOREIGN KEY (nombre) REFERENCES buques(nombre)
)

CREATE TABLE Atenciones (
	aten_id INT PRIMARY KEY,
    fecha_ate DATE NOT NULL,
    fecha_cie DATE NOT NULL,
    fecha_reg DATE NOT NULL,
    admin_turno VARCHAR(100) NOT NULL,
    num_turnos INT(11) NOT NULL,
    observaciones VARCHAR(100) NOT NULL,
	usuario_id INT,
    codigo VARCHAR(100),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id),
    FOREIGN KEY (codigo) REFERENCES recaladas(codigo)
)

CREATE TABLE Turno (
	turno_id INT PRIMARY KEY,
    fecha_reg DATE NOT NULL,
    estado VARCHAR(100) NOT NULL,
    pos_turnos INT(11) NOT NULL,
    observaciones VARCHAR(100) NOT NULL,
	usuario_id INT,
    aten_id INT,
    cedula VARCHAR(100),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(usuario_id),
    FOREIGN KEY (aten_id) REFERENCES atenciones(aten_id),
    FOREIGN KEY (cedula) REFERENCES guias(cedula)
)

CREATE TABLE Gestion_Turno (
	ges_tur_id INT PRIMARY KEY,
    fecha_hor_sal DATE NOT NULL,
    fecha_hor_regreso DATE NOT NULL,
    fecha_hor_aten DATE NOT NULL,
    observaciones VARCHAR(100) NOT NULL,
	aten_id INT,
    turno_id INT,
    FOREIGN KEY (aten_id) REFERENCES atenciones(aten_id),
    FOREIGN KEY (turno_id) REFERENCES turno(turno_id)
)

