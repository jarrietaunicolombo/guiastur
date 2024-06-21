<?php

class Usuario
{
    private $id;
    private $email;
    private $password;
    private $nombre;
    private $estado;
    private $rol_id;
    private $guia_o_supervisor_id;
    private $fecha_registro;
    private $usuario_registro;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->nombre = $data['nombre'];
        $this->estado = $data['estado'];
        $this->rol_id = $data['rol_id'];
        $this->guia_o_supervisor_id = $data['guia_o_supervisor_id'];
        $this->fecha_registro = $data['fecha_registro'];
        $this->usuario_registro = $data['usuario_registro'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): void
    {
        $this->estado = $estado;
    }

    public function getRolId(): int
    {
        return $this->rol_id;
    }

    public function setRolId(int $rol_id): void
    {
        $this->rol_id = $rol_id;
    }

    public function getGuiaOSupervisorId()
    {
        return $this->guia_o_supervisor_id;
    }

    public function setGuiaOSupervisorId($guia_o_supervisor_id): void
    {
        $this->guia_o_supervisor_id = $guia_o_supervisor_id;
    }

    public function getFechaRegistro(): \DateTime
    {
        return new \DateTime($this->fecha_registro);
    }

    public function setFechaRegistro(\DateTime $fecha_registro): void
    {
        $this->fecha_registro = $fecha_registro->format('Y-m-d H:i:s');
    }

    public function getUsuarioRegistro(): int
    {
        return $this->usuario_registro;
    }

    public function setUsuarioRegistro(int $usuario_registro): void
    {
        $this->usuario_registro = $usuario_registro;
    }
}

// ********************************************

class Rol
{
    private $id;
    private $nombre;
    private $descripcion;
    private $icono;
    private $fecha_registro;
    private $usuario_registro;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->nombre = $data['nombre'];
        $this->descripcion = $data['descripcion'];
        $this->icono = $data['icono'];
        $this->fecha_registro = $data['fecha_registro'];
        $this->usuario_registro = $data['usuario_registro'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function getIcono(): string
    {
        return $this->icono;
    }

    public function setIcono(string $icono): void
    {
        $this->icono = $icono;
    }

    public function getFechaRegistro(): \DateTime
    {
        return new \DateTime($this->fecha_registro);
    }

    public function setFechaRegistro(\DateTime $fecha_registro): void
    {
        $this->fecha_registro = $fecha_registro->format('Y-m-d H:i:s');
    }

    public function getUsuarioRegistro(): int
    {
        return $this->usuario_registro;
    }

    public function setUsuarioRegistro(int $usuario_registro): void
    {
        $this->usuario_registro = $usuario_registro;
    }
}


// *******************************************************

class Guia
{
    private $cedula;
    private $rnt;
    private $nombres;
    private $apellidos;
    private $fecha_nacimiento;
    private $genero;
    private $foto;
    private $observaciones;
    private $usuario_id;
    private $fecha_registro;
    private $usuario_registro;

    public function __construct(array $data)
    {
        $this->cedula = $data['cedula'];
        $this->rnt = $data['rnt'];
        $this->nombres = $data['nombres'];
        $this->apellidos = $data['apellidos'];
        $this->fecha_nacimiento = $data['fecha_nacimiento'];
        $this->genero = $data['genero'];
        $this->foto = $data['foto'];
        $this->observaciones = $data['observaciones'];
        $this->usuario_id = $data['usuario_id'];
        $this->fecha_registro = $data['fecha_registro'];
        $this->usuario_registro = $data['usuario_registro'];
    }

    public function getCedula(): string
    {
        return $this->cedula;
    }

    public function setCedula(string $cedula): void
    {
        $this->cedula = $cedula;
    }

    public function getRnt(): string
    {
        return $this->rnt;
    }

    public function setRnt(string $rnt): void
    {
        $this->rnt = $rnt;
    }

    public function getNombres(): string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): void
    {
        $this->nombres = $nombres;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function getFechaNacimiento(): \DateTime
    {
        return new \DateTime($this->fecha_nacimiento);
    }

    public function setFechaNacimiento(\DateTime $fecha_nacimiento): void
    {
        $this->fecha_nacimiento = $fecha_nacimiento->format('Y-m-d');
    }

    public function getGenero(): string
    {
        return $this->genero;
    }

    public function setGenero(string $genero): void
    {
        $this->genero = $genero;
    }

    public function getFoto(): string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): void
    {
        $this->foto = $foto;
    }

    public function getObservaciones(): string
    {
        return $this->observaciones;
    }

    public function setObservaciones(string $observaciones): void
    {
        $this->observaciones = $observaciones;
    }

    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }

    public function setUsuarioId(int $usuario_id): void
    {
        $this->usuario_id = $usuario_id;
    }

    public function getFechaRegistro(): \DateTime
    {
        return new \DateTime($this->fecha_registro);
    }

    public function setFechaRegistro(\DateTime $fecha_registro): void
    {
        $this->fecha_registro = $fecha_registro->format('Y-m-d H:i:s');
    }

    public function getUsuarioRegistro(): int
    {
        return $this->usuario_registro;
    }

    public function setUsuarioRegistro(int $usuario_registro): void
    {
        $this->usuario_registro = $usuario_registro;
    }
}


// ******************************************************

class Supervisor
{
    private $cedula;
    private $rnt;
    private $nombres;
    private $apellidos;
    private $fecha_nacimiento;
    private $genero;
    private $foto;
    private $observaciones;
    private $usuario_id;
    private $fecha_registro;
    private $usuario_registro;

    public function __construct(array $data)
    {
        $this->cedula = $data['cedula'];
        $this->rnt = $data['rnt'];
        $this->nombres = $data['nombres'];
        $this->apellidos = $data['apellidos'];
        $this->fecha_nacimiento = $data['fecha_nacimiento'];
        $this->genero = $data['genero'];
        $this->foto = $data['foto'];
        $this->observaciones = $data['observaciones'];
        $this->usuario_id = $data['usuario_id'];
        $this->fecha_registro = $data['fecha_registro'];
        $this->usuario_registro = $data['usuario_registro'];
    }

    public function getCedula(): string
    {
        return $this->cedula;
    }

    public function setCedula(string $cedula): void
    {
        $this->cedula = $cedula;
    }

    public function getRnt(): string
    {
        return $this->rnt;
    }

    public function setRnt(string $rnt): void
    {
        $this->rnt = $rnt;
    }

    public function getNombres(): string
    {
        return $this->nombres;
    }

    public function setNombres(string $nombres): void
    {
        $this->nombres = $nombres;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function getFechaNacimiento(): \DateTime
    {
        return new \DateTime($this->fecha_nacimiento);
    }

    public function setFechaNacimiento(\DateTime $fecha_nacimiento): void
    {
        $this->fecha_nacimiento = $fecha_nacimiento->format('Y-m-d');
    }

    public function getGenero(): string
    {
        return $this->genero;
    }

    public function setGenero(string $genero): void
    {
        $this->genero = $genero;
    }

    public function getFoto(): string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): void
    {
        $this->foto = $foto;
    }

    public function getObservaciones(): string
    {
        return $this->observaciones;
    }

    public function setObservaciones(string $observaciones): void
    {
        $this->observaciones = $observaciones;
    }

    public function getUsuarioId(): int
    {
        return $this->usuario_id;
    }

    public function setUsuarioId(int $usuario_id): void
    {
        $this->usuario_id = $usuario_id;
    }

    public function getFechaRegistro(): \DateTime
    {
        return new \DateTime($this->fecha_registro);
    }

    public function setFechaRegistro(\DateTime $fecha_registro): void
    {
        $this->fecha_registro = $fecha_registro->format('Y-m-d H:i:s');
    }

    public function getUsuarioRegistro(): int
    {
        return $this->usuario_registro;
    }

    public function setUsuarioRegistro(int $usuario_registro): void
    {
        $this->usuario_registro = $usuario_registro;
    }
}

// **********************************
class Buque
{
    private $id;
    private $codigo;
    private $nombre;
    private $foto;
    private $fecha_registro;
    private $usuario_registro;

    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->codigo = $data['codigo'];
        $this->nombre = $data['nombre'];
        $this->foto = $data['foto'];
        $this->fecha_registro = $data['fecha_registro'];
        $this->usuario_registro = $data['usuario_registro'];
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCodigo(): string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): void
    {
        $this->codigo = $codigo;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getFoto(): string
    {
        return $this->foto;
    }

    public function setFoto(string $foto): void
    {
        $this->foto = $foto;
    }

    public function getFechaRegistro(): \DateTime
    {
        return new \DateTime($this->fecha_registro);
    }

    public function setFechaRegistro(\DateTime $fecha_registro): void
    {
        $this->fecha_registro = $fecha_registro->format('Y-m-d H:i:s');
    }

    public function getUsuarioRegistro(): int
    {
        return $this->usuario_registro;
    }

    public function setUsuarioRegistro(int $usuario_registro): void
    {
        $this->usuario_registro = $usuario_registro;
    }
}


// **********************************************

class Recalada
{
    private $id;
    private $fecha_arribo;
    private $fecha_zarpe;
    private $total_turistas;
    private $observaciones;
    private $buque_id;
    private $pais_id;
    private $fecha_registro;
    private $usuario_registro;

    public function __construct(
        $id,
        $fecha_arribo,
        $fecha_zarpe,
        $total_turistas,
        $observaciones,
        $buque_id,
        $pais_id,
        $fecha_registro,
        $usuario_registro
    ) {
        $this->id = $id;
        $this->fecha_arribo = $fecha_arribo;
        $this->fecha_zarpe = $fecha_zarpe;
        $this->total_turistas = $total_turistas;
        $this->observaciones = $observaciones;
        $this->buque_id = $buque_id;
        $this->pais_id = $pais_id;
        $this->fecha_registro = $fecha_registro;
        $this->usuario_registro = $usuario_registro;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFechaArribo()
    {
        return $this->fecha_arribo;
    }

    public function setFechaArribo($fecha_arribo)
    {
        $this->fecha_arribo = $fecha_arribo;
    }

    public function getFechaZarpe()
    {
        return $this->fecha_zarpe;
    }

    public function setFechaZarpe($fecha_zarpe)
    {
        $this->fecha_zarpe = $fecha_zarpe;
    }

    public function getTotalTuristas()
    {
        return $this->total_turistas;
    }

    public function setTotalTuristas($total_turistas)
    {
        $this->total_turistas = $total_turistas;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    public function getBuqueId()
    {
        return $this->buque_id;
    }

    public function setBuqueId($buque_id)
    {
        $this->buque_id = $buque_id;
    }

    public function getPaisId()
    {
        return $this->pais_id;
    }

    public function setPaisId($pais_id)
    {
        $this->pais_id = $pais_id;
    }

    public function getFechaRegistro()
    {
        return $this->fecha_registro;
    }

    public function setFechaRegistro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

    public function getUsuarioRegistro()
    {
        return $this->usuario_registro;
    }

    public function setUsuarioRegistro($usuario_registro)
    {
        $this->usuario_registro = $usuario_registro;
    }
}

// *************************************************

class Pais
{
    private $id;
    private $nombre;
    private $bandera;
    private $fecha_registro;
    private $usuario_registro;

    public function __construct(
        $id,
        $nombre,
        $bandera,
        $fecha_registro,
        $usuario_registro
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->bandera = $bandera;
        $this->fecha_registro = $fecha_registro;
        $this->usuario_registro = $usuario_registro;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getBandera()
    {
        return $this->bandera;
    }

    public function setBandera($bandera)
    {
        $this->bandera = $bandera;
    }

    public function getFechaRegistro()
    {
        return $this->fecha_registro;
    }

    public function setFechaRegistro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

    public function getUsuarioRegistro()
    {
        return $this->usuario_registro;
    }

    public function setUsuarioRegistro($usuario_registro)
    {
        $this->usuario_registro = $usuario_registro;
    }
}


// **********************************

class Atencion
{
    private $id;
    private $fecha_inicio;
    private $fecha_cierre;
    private $total_turnos;
    private $observaciones;
    private $supervisor_id;
    private $recalada_id;
    private $fecha_registro;
    private $usuario_registro;

    public function __construct(
        $id,
        $fecha_inicio,
        $fecha_cierre,
        $total_turnos,
        $observaciones,
        $supervisor_id,
        $recalada_id,
        $fecha_registro,
        $usuario_registro
    ) {
        $this->id = $id;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_cierre = $fecha_cierre;
        $this->total_turnos = $total_turnos;
        $this->observaciones = $observaciones;
        $this->supervisor_id = $supervisor_id;
        $this->recalada_id = $recalada_id;
        $this->fecha_registro = $fecha_registro;
        $this->usuario_registro = $usuario_registro;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getFechaInicio()
    {
        return $this->fecha_inicio;
    }

    public function setFechaInicio($fecha_inicio)
    {
        $this->fecha_inicio = $fecha_inicio;
    }

    public function getFechaCierre()
    {
        return $this->fecha_cierre;
    }

    public function setFechaCierre($fecha_cierre)
    {
        $this->fecha_cierre = $fecha_cierre;
    }

    public function getTotalTurnos()
    {
        return $this->total_turnos;
    }

    public function setTotalTurnos($total_turnos)
    {
        $this->total_turnos = $total_turnos;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    public function getSupervisorId()
    {
        return $this->supervisor_id;
    }

    public function setSupervisorId($supervisor_id)
    {
        $this->supervisor_id = $supervisor_id;
    }

    public function getRecaladaId()
    {
        return $this->recalada_id;
    }

    public function setRecaladaId($recalada_id)
    {
        $this->recalada_id = $recalada_id;
    }

    public function getFechaRegistro()
    {
        return $this->fecha_registro;
    }

    public function setFechaRegistro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

    public function getUsuarioRegistro()
    {
        return $this->usuario_registro;
    }

    public function setUsuarioRegistro($usuario_registro)
    {
        $this->usuario_registro = $usuario_registro;
    }
}


    // *************************************************

    class Turno
{
    private $id;
    private $numero;
    private $estado;
    private $fecha_uso;
    private $fecha_salida;
    private $fecha_regreso;
    private $observaciones;
    private $guia_id;
    private $atencion_id;
    private $fecha_registro;
    private $usuario_registro;

    public function __construct(
        $id,
        $numero,
        $estado,
        $fecha_uso,
        $fecha_salida,
        $fecha_regreso,
        $observaciones,
        $guia_id,
        $atencion_id,
        $fecha_registro,
        $usuario_registro
    ) {
        $this->id = $id;
        $this->numero = $numero;
        $this->estado = $estado;
        $this->fecha_uso = $fecha_uso;
        $this->fecha_salida = $fecha_salida;
        $this->fecha_regreso = $fecha_regreso;
        $this->observaciones = $observaciones;
        $this->guia_id = $guia_id;
        $this->atencion_id = $atencion_id;
        $this->fecha_registro = $fecha_registro;
        $this->usuario_registro = $usuario_registro;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getFechaUso()
    {
        return $this->fecha_uso;
    }

    public function setFechaUso($fecha_uso)
    {
        $this->fecha_uso = $fecha_uso;
    }

    public function getFechaSalida()
    {
        return $this->fecha_salida;
    }

    public function setFechaSalida($fecha_salida)
    {
        $this->fecha_salida = $fecha_salida;
    }

    public function getFechaRegreso()
    {
        return $this->fecha_regreso;
    }

    public function setFechaRegreso($fecha_regreso)
    {
        $this->fecha_regreso = $fecha_regreso;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }

    public function getGuiaId()
    {
        return $this->guia_id;
    }

    public function setGuiaId($guia_id)
    {
        $this->guia_id = $guia_id;
    }

    public function getAtencionId()
    {
        return $this->atencion_id;
    }

    public function setAtencionId($atencion_id)
    {
        $this->atencion_id = $atencion_id;
    }

    public function getFechaRegistro()
    {
        return $this->fecha_registro;
    }

    public function setFechaRegistro($fecha_registro)
    {
        $this->fecha_registro = $fecha_registro;
    }

    public function getUsuarioRegistro()
    {
        return $this->usuario_registro;
    }

    public function setUsuarioRegistro($usuario_registro)
    {
        $this->usuario_registro = $usuario_registro;
    }
}
