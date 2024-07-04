<?php
class CancelTurnoRequest{
    private $turnoId; 
    private $usuarioCancelId; 
    private $observaciones;
    
    public function __construct(int $turnoId, int $usuarioCancelId, string $observaciones) {
        if(!isset($turnoId) || $turnoId < 1){
            throw new \InvalidArgumentException("El Id del Tunro es requerido para Cancelar el Turno");
        }

        if(!isset($usuarioCancelId) || $usuarioCancelId < 1 ){
            throw new \InvalidArgumentException("El Id del Usuario que registra el Uso es requerido para Cancelar el Turno");
        }

        if(!isset($observaciones) || empty(trim($observaciones)) ){
            throw new \InvalidArgumentException("Las observaciones son requeridas para Cancelar el Turno");
        }

        $this->turnoId = $turnoId;
        $this->usuarioCancelId = $usuarioCancelId;
        $this->observaciones = $observaciones;
     
    }

    public function getTurnoId(): int {
        return $this->turnoId;
    }

    public function getUsuarioCancelId(): int {
        return $this->usuarioCancelId;
    }

    public function getObservaciones() : string {
        return $this->observaciones;
    }

}