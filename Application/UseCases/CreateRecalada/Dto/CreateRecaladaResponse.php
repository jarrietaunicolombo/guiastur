<?php
require_once __DIR__ . "/CreateRecaladaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GenericDto.php";
class CreateRecaladaResponse extends GenericDto
{
    private $id;
 

    public function __construct(int $id)
    {
        if (!isset($id) || $id <= 0) {
            throw new \InvalidArgumentException("El ID de la nueva Recalada creada es requerido");
        }
        $this->id = $id;
    }

    public function getId(): int{
        return $this->id;
    }
}