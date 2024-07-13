<?php

class GetPaisesResponse{
    private $paises;
    public function __construct(array $paises){
        if ($paises === null) {
            $paises = array();
        }
        $this->paises = $paises;
    }
    public function getPaises() : array{
        return $this->paises;
    }
}


class PaisResponse{
    private $id;
    private $nombre;
    private $bandera;

    public function __construct(int $id, string $nombre, string $bandera = null) {
        if($id === null || $id < 1) {
            throw new \InvalidArgumentException("El Id es requerido para Obtener los Paises");
        }
        if($nombre === null || empty(trim($nombre))) {
            throw new \InvalidArgumentException("El Nombre es requerido para Obtener los Paises");
        }

        $this->id = $id;
        $this->nombre = $nombre;    
        $this->bandera = $bandera;  
    }

    public function getId(): int { 
        return $this->id;
    }

    public function getNombre(): string {   
        return $this->nombre;
    }

    public function getBandera() {
        return $this->bandera;
    }
}
