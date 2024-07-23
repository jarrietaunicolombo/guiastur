<?php
class GetSupervisorByCedulaRequest{
    private $cedula; 
    
    public function __construct(string $cedula) {
        if($cedula === null || empty(trim($cedula))){
            throw new InvalidArgumentException("La Cedula del Supervisor es requerida para obtener un Supervisor por Cedula");
        }
        $this->cedula = $cedula;
    }

    public function getCedula(): string {
        return $this->cedula;
    }
}