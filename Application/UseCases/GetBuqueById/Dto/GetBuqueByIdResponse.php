<?php

class GetBuqueByIdResponse
{
    private $id;
    private $codigo;
    private $nombre;
    private $foto;
    private $total_recaladas;
    private $total_atenciones;

    public function __construct(int $id, string $codigo = null, string $nombre, string $foto = null, int $total_recaladas = 0, int $total_atenciones = 0)
    {
        if ($id < 1) {
            throw new \InvalidArgumentException("El Bueque Id es requerido para Obtener el Buque Por Id");
        }

        if ($nombre == null || empty(trim($nombre))) {
            throw new \InvalidArgumentException("El Nombre del Buque es requerido para Obtener el Buque Por Id");
        }

        $this->id = $id;
        $this->codigo = $codigo;
        $this->nombre = $nombre;
        $this->foto = $foto;
        $this->total_recaladas = $total_recaladas;
        $this->total_atenciones = $total_atenciones;

    }


    public function getId()
    {
        return $this->id;
    }

    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getFoto()
    {
        return $this->foto;
    }

    public function getTotalRecaladas()
    {
        return $this->total_recaladas;
    }

    public function getTotalAtenciones()
    {
        return $this->total_atenciones;
    }

}