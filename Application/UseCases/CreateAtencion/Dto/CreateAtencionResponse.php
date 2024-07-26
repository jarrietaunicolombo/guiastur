<?php
require_once __DIR__ . "/CreateAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GenericDto.php";
class CreateAtencionResponse extends GenericDto
{
    private $id;

    public function __construct(int $id){
        if(!isset($id) || $id <= 0){
            throw new InvalidArgumentException("Es requerido el ID de la nueva Atencion");
        }

        $this->id = $id;    
    }

    public function getId() : int{
        return $this->id;
    }
}