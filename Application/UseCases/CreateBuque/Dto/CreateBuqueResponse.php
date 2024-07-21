<?php
require_once __DIR__ . "/CreateBuqueRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"]."guiastur/Application/UseCases/GenericDto.php";
class CreateBuqueResponse extends GenericDto
{
    private $id;
   

    public function __construct(int $id)
    {
        if (!isset($id) || $id < 1) {
            throw new \InvalidArgumentException("El Id del nuevo Buque es requerido");
        }

        $this->id = $id;
    }

    public function getId(): int{
        return $this->id;
    }

}

