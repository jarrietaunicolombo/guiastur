<?php
class CreateRecaladaRequest
{
    private $fecha_arribo;
    private $fecha_zarpe;
    private $total_turistas;
    private $observaciones;
    private $buque_id;
    private $pais_id;
    private $fecha_registro;
    private $usuario_registro;

    public function __construct(
        $fecha_arribo,
        $fecha_zarpe = null,
        $total_turistas,
        $observaciones = null,
        $buque_id,
        $pais_id,
        $usuario_registro
    ) {
        if (!isset($fecha_arribo)) {
            throw new \InvalidArgumentException("La Fecha de Arribo de la nueva Recalada requerida");
        }
        if (!isset($total_turistas) || $total_turistas <= 0) {
            throw new \InvalidArgumentException("El Numero de turistas de la nueva Recalada es requerido");
        }
        if (!isset($buque_id) || $buque_id <= 0 ) {
            throw new \InvalidArgumentException("El BuqueId de la nueva Recalada es requerido");
        }

        if (!isset($pais_id) || $pais_id <= 0 ) {
            throw new \InvalidArgumentException("El PaisId de la nueva Recalada es requerido");
        }

        if (!isset($usuario_registro) || $usuario_registro <= 0 ) {
            throw new \InvalidArgumentException("El UsuarioRegistroID de la nueva Recalada es requerido");
        }

        if (isset($observaciones) && empty(trim($observaciones)) ) {
            $observaciones = null;
        }

        if (isset($fecha_zarpe) && $fecha_arribo > $fecha_zarpe)  {
            throw new \InvalidArgumentException("La Fecha de Arribo no puede ser mayor que la Fecha de Zarpe para la nueva Recaladad");
        }


        $this->fecha_arribo = $fecha_arribo;
        $this->fecha_zarpe = $fecha_zarpe;
        $this->total_turistas = $total_turistas;
        $this->observaciones = $observaciones;
        $this->buque_id = $buque_id;
        $this->pais_id = $pais_id;
        $this->fecha_registro = new DateTime();
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