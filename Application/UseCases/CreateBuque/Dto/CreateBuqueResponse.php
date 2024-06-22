<?php
require_once __DIR__ . "/CreateBuqueRequest.php";
class CreateBuqueResponse
{
    private $id;
    private $buque;

    public function __construct(int $id, CreateBuqueRequest $buque)
    {
        if (!isset($id) || $id <= 0) {
            throw new \InvalidArgumentException("El Id del nuevo Buque es requerido");
        }

        if (!isset($buque)) {
            throw new \InvalidArgumentException("El nuevo Buque es requerido");
        }

        $this->buque = $buque;
        $this->id = $id;
    }

    public function getId(): int{
        return $this->id;
    }

    public function getBuque(): CreateBuqueRequest
    {
        return $this->buque;
    }
}

