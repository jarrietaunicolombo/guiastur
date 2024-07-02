<?php
class GetNextTurnoRequest{
    private $atencionId; 
    
    public function __construct(int $atencionId) {
        if(!isset($atencionId) || $atencionId <= 0 ){
            throw new \InvalidArgumentException("La AtencionId es requerida para Obtemer el Proximo Turno");
        }
        $this->atencionId = $atencionId;
    }

    public function getAtencionId(): int {
        return $this->atencionId;
    }
}