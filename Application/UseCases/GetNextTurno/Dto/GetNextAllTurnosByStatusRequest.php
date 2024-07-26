<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/TurnoStatusEnum.php";


class GetNextAllTurnosByStatusRequest{
    private $turnoStatus; 
    
    public function __construct(string $turnoStatus) {
        if(!isset($turnoStatus) || empty(trim($turnoStatus)) ){
            throw new \InvalidArgumentException("El Estado del Turno es requerida para Obtemer los siguientes turnos Por Estado");
        }

        $turnoStatusValues = TurnoStatusEnum::getConstansValues();
        if(!in_array($turnoStatus, $turnoStatusValues)){
            throw new \InvalidArgumentException("[$turnoStatus] no es un Estado valido para Obtener los Siguientes Turnos por Estado");
        }

        $this->turnoStatus = $turnoStatus;
    }

    public function getTurnoStatus(): string {
        return $this->turnoStatus;
    }
}