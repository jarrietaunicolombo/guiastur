<?php
class GetTurnosByAtencionRequest{
    private $atencionId; 
    
    public function __construct(int $atencionId) {
        if(!isset($atencionId) || $atencionId <= 0 ){
            throw new \InvalidArgumentException("El AtencionId es requerido para obtener los Turnos por Atencion");
        }
        $this->atencionId = $atencionId;
    }

    public function getAtencionId(): int {
        return $this->atencionId;
    }
}