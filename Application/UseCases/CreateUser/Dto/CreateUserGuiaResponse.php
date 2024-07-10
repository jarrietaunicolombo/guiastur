<?php
require_once __DIR__ ."/CreateUserGuiaRequest.php";
class CreateUserGuiaResponse extends CreateUserGuiaRequest
{
    public function __construct(
        int $id,
        string $email,
        string $password,
        string $nombre,
        string $estado,
        int $rol_id,
        string $rol_nombre,
        string $validation_token,
        string $cedula,
        string $rnt,
        string $nombres,
        string $apellidos,
        string $genero,
        DateTime $fecha_nacimiento,
        string $telefono,
        string $foto = NULL,
        string $observaciones = NULL,
        int $usuario_create,
        DateTime $fecha_registro
    ) {
        if ( $id <= 0) {
            throw new InvalidArgumentException("El Id   es requerido al crear un nuevo Usuario Guia al crear un nuevo Usuario Guia");
        }

        if ( empty(trim($email))) {
            throw new InvalidArgumentException("El Email  es requerido al crear un nuevo Usuario Guia");
        }

        if (empty(trim($password))) {
            throw new InvalidArgumentException("El Password  es requerido al crear un nuevo Usuario Guia");
        }

        if (empty(trim($nombre))) {
            throw new InvalidArgumentException("El Nombre  es requerido al crear un nuevo Usuario Guia");
        }
        if (empty(trim($estado))) {
            throw new InvalidArgumentException("El Estado  es requerido al crear un nuevo Usuario Guia");
        }

        if ( $rol_id < 1) {
            throw new InvalidArgumentException("El Rol  es requerido al crear un nuevo Usuario Guia");
        }

        if ( empty(trim($rol_nombre))) {
            throw new InvalidArgumentException("El Nombre del Rol   es requerido al crear un nuevo Usuario Guia al crear un nuevo Usuario Guia");
        }

        if ( empty(trim($validation_token))) {
            throw new InvalidArgumentException("El Token de Validacion   es requerido al crear un nuevo Usuario Guia al crear un nuevo Usuario Guia");
        }

        if ($usuario_create < 1) {
            throw new InvalidArgumentException("El Usuario creador  es requerido al crear un nuevo Usuario Guia");
        }

        if ($cedula === NULL || empty(trim($cedula))) {
            throw new InvalidArgumentException("La Cedula es requerida al crear un nuevo usuario guia");
        }

        if ($rnt === NULL || empty(trim($rnt))) {
            throw new InvalidArgumentException("El RNT  es requerido al crear un nuevo Usuario Guia ");
        }

        if ($nombres === NULL || empty(trim($nombres))) {
            throw new InvalidArgumentException("El Nombre  es requerido al crear un nuevo Usuario Guia ");
        }

        if ($apellidos === NULL || empty(trim($apellidos))) {
            throw new InvalidArgumentException("Los Apellidos son requeridos ");
        }

        if ($genero === NULL || empty(trim($genero))) {
            throw new InvalidArgumentException("El Genero  es requerido al crear un nuevo Usuario Guia ");
        }

        if ($fecha_nacimiento === NULL) {
            throw new InvalidArgumentException("La Fecha de nacimiento es requerida ");
        }

        if ($fecha_nacimiento > new DateTime()) {
            throw new InvalidArgumentException("La Fecha de nacimiento no puede ser mayor a la fecha de creacion del nuevo usuario guia");
        }

        if ($telefono === NULL || empty(trim($telefono))) {
            throw new InvalidArgumentException("El Telefono   es requerido al crear un nuevo Usuario Guia ");
        }

        if ($fecha_registro === NULL) {
            throw new InvalidArgumentException("La Fecha de registro es requerida al crear un nuevo Usuario Guia ");
        }

        
        if ($usuario_create === NULL) {
            throw new InvalidArgumentException("El Usuario que registra es requerido al crear un nuevo Usuario Guia ");
        }

        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->nombre = $nombre;
        $this->rol_id = $rol_id;
        $this->validation_token = $validation_token;
        $this->rol_nombre = $rol_nombre;
        $this->cedula = $cedula;
        $this->rnt = $rnt;
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->genero = $genero;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->estado = $estado;
        $this->telefono = $telefono;
        $this->observaciones = $observaciones;
        $this->foto = $foto;
        $this->fecha_registro = $fecha_registro;
        $this->usuario_registro = $usuario_create;
    }
}