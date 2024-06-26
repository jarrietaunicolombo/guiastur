<?php
class GetRecaladasInThePortResponse
{
    private $recaladaId;
    private  $buque_id;
    private  $buque_nombre;
    private  $fecha_arribo ;
    private  $fecha_zarpe ;
    private  $total_turistas;
    private  $pais_id;
    private  $pais_nombre;
    private  $numero_atenciones;
    private  $observaciones;

    public function __construct(
        int $recaladaId,
        int $buque_id,
        string $buque_nombre,
        DateTime $fecha_arribo = null,
        DateTime $fecha_zarpe = null,
        int $total_turistas,
        int $pais_id,
        string $pais_nombre,
        string $observaciones = null,
        int $numero_atenciones
    ) {
        if ($recaladaId <= 0) {
            throw new InvalidArgumentException("La RecaladaId es requerida para Obtener Las Recaladas En El Puerto");
        }

        if ($buque_id <= 0) {
            throw new InvalidArgumentException("El BuqueId es requerido para Obtener Las Recaladas En El Puerto");
        }

        if ($buque_nombre === NULL || empty(trim($buque_nombre))) {
            throw new InvalidArgumentException("El Nombre del Buque es requerido para Obtener Las Recaladas En El Puerto");
        }

        if ($fecha_arribo === NULL) {
            throw new InvalidArgumentException("La Fecha de Arribo es requerida para Obtener Las Recaladas En El Puerto");
        }

        if ($fecha_zarpe === NULL) {
            throw new InvalidArgumentException("La Fecha de Zarpe es requerida para Obtener Las Recaladas En El Puerto");
        }

        if ($total_turistas <= 0) {
            throw new InvalidArgumentException("La Numero de Turistas  requerido para Obtener Las Recaladas En El Puerto");
        }

        if ($pais_id <= 0) {
            throw new InvalidArgumentException("El PaisId  requerido para Obtener Las Recaladas En El Puerto");
        }

        if ($pais_nombre === NULL || empty(trim($pais_nombre))) {
            throw new InvalidArgumentException("El Nombre del Pais es requerido para Obtener Las Recaladas En El Puerto");
        }

        $this->recaladaId = $recaladaId;
        $this->buque_id = $buque_id;
        $this->buque_nombre = $buque_nombre;
        $this->fecha_arribo = $fecha_arribo;
        $this->fecha_zarpe = $fecha_zarpe;
        $this->total_turistas = $total_turistas;
        $this->pais_id = $pais_id;
        $this->pais_nombre = $pais_nombre;
        $this->observaciones = $observaciones;
        $this->numero_atenciones = $numero_atenciones;
    }

    public function getRecaladaId(){
        return $this->recaladaId;
    }

    public function getBuqueId() { 
        return $this->buque_id;
    }

    public function getBuqueNombre() {
        return $this->buque_nombre;
    }   

    public function getFechaArribo() {
        return $this->fecha_arribo;
    }

    public function getFechaZarpe() {  
        return $this->fecha_zarpe;
    }

    public function getTotalTuristas() {
        return $this->total_turistas;
    }

    public function getPaisId() {
        return $this->pais_id;
    }

    public function getPaisNombre() {
        return $this->pais_nombre;
    }

    public function getNumeroAtenciones() {
        return $this->numero_atenciones;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

}