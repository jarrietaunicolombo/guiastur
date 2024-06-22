<?php
require_once __DIR__ . "/CreateAtencionRequest.php";

class CreateAtencionResponse
{
    private $id;
    private $atencion;

    public function __construct(int $id, CreateAtencionRequest $atencion){
        if(!isset($id) || $id <= 0){
            throw new InvalidArgumentException("Es requerido el ID de la nueva Atencion");
        }

        if(!isset($atencion)){
            throw new InvalidArgumentException("La nueva Atencion es requerida");
        }

        $this->id = $id;    
        $this->atencion = $atencion;
    }

    public function getId() : int{
        return $this->id;
    }

    public function getAtencion () : CreateAtencionRequest {
        return $this->atencion;
    }
}