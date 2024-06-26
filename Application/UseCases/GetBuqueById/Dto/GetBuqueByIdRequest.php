<?php

class GetBuqueByIdRequest{
    private $id;

    public function __construct(int $id)
    {
        if ($id < 1) {
            throw new \InvalidArgumentException("El Bueque Id es requerido para Obtener el Buque Por Id");
        }
        $this->id = $id;

    }


    public function getId()
    {
        return $this->id;
    }

}