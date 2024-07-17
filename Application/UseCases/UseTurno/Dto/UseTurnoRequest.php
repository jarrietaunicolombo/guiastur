<?php
class UseTurnoRequest{
    private $turnoId; 
    private $usuarioUsoId; 
    private $atencionId;
    private $observaciones;
    
    public function __construct(int $turnoId, int $usuarioUsoId, int $atencionId, string $observaciones = null) {
        if(!isset($turnoId) || $turnoId < 1){
            throw new \InvalidArgumentException("El Id del Tunro es requerido para Usar el Turno");
        }

        if(!isset($usuarioUsoId) || $usuarioUsoId < 1 ){
            throw new \InvalidArgumentException("El Id del Usuario que registra el Uso es requerido para Usar el Turno");
        }

        if(!isset($atencionId) || $atencionId < 1 ){
            throw new \InvalidArgumentException("El Id de la Atencion es requerido para Usar el Turno");
        }

        $this->turnoId = $turnoId;
        $this->usuarioUsoId = $usuarioUsoId;
        $this->atencionId = $atencionId;
        $this->observaciones = $observaciones;
    }

    public function getTurnoId(): int {
        return $this->turnoId;
    }

    public function getUsuarioUsoId(): int {
        return $this->usuarioUsoId;
    }

    public function getAtencionId(): int {
        return $this->atencionId;
    }

    public function getObservaciones(){
        $this->observaciones;
    }
}