<?php
class GetUsuarioByIdRequest{
    private $usuarioId; 
    
    public function __construct(int $usuarioId) {
        if($usuarioId === null || $usuarioId < 1){
            throw new \InvalidArgumentException("El ID del Usuario es requerido para obtener el Usuario por ID");
        }
        $this->usuarioId = $usuarioId;
    }

    public function getUsuarioId(): int {
        return $this->usuarioId;
    }
}