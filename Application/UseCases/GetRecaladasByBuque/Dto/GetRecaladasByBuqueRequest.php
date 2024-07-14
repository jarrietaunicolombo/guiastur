<?php

class GetRecaladasByBuqueRequest{

    private $buqueId;

    public function __construct(int $buqueId){
        if( $buqueId === null || $buqueId < 1){
            throw new \InvalidArgumentException("El Id del Buque es requerido para obtener sus Recaldas");
        }
        
        $this->buqueId = $buqueId;
    }

    public function getBuqueId(): int{
        return $this->buqueId;
    }
}