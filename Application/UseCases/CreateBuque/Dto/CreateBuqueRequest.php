<?php
class CreateBuqueRequest
{

    private $codigo;
    private $nombre;
    private $foto;
    private $fecha_registro;
    private $usuario_registro;

    public function __construct(string $codigo = null, string $nombre, string $foto = null, int $usuario_registro)
    {
        if (!isset($codigo) || empty(trim($codigo))) {
            $codigo = null;
        }
        if (!isset($nombre) || empty(trim($nombre))) {
            throw new \InvalidArgumentException("El Nombre del nuevo Buque es requerido");
        }

        if (!isset($foto) || empty(trim($foto))) {
            $foto = null;
        }

        if (!isset($usuario_registro) || $usuario_registro <= 0) {
            throw new \InvalidArgumentException("El Usuario de Registo del nuevo Buque es requerido");
        }
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->foto = $foto;
        $this->fecha_registro = new DateTime();
        $this->usuario_registro = $usuario_registro;
    }

    public function getCodigo(): string
    {
        return $this->codigo;
    }


    public function getNombre(): string
    {
        return $this->nombre;
    }


    public function getFoto(): string
    {
        return $this->foto;
    }


    public function getFechaRegistro(): \DateTime
    {
        return new $this->fecha_registro;
    }


    public function getUsuarioRegistro(): int
    {
        return $this->usuario_registro;
    }
}