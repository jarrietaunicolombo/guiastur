<?php
class GetUsuarioByTokenRequest{
    private $id;
    private $token;

    public function __construct(int $id, string $token){
        if($id === null || $id < 1){
            throw new \InvalidArgumentException("El Id del Usuario es requerido para Obetener Usuario Por Token");
        }
        if($token === null || empty(trim($token))){
            throw new \InvalidArgumentException("El Token es requerido para Obetener Usuario Por Token");
        }
        $this->id = $id;
        $this->token = $token;
    }
    
    public function getId(): int{
        return $this->id;
    }

    public function getToken(): string{
        return $this->token;
    }


}