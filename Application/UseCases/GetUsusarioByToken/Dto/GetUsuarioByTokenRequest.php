<?php
class GetUsuarioByTokenRequest{
    private $token;

    public function __construct(string $token){
        if($token === NULL || empty(trim($token))){
            throw new \InvalidArgumentException("El Token es requerido para Obetener Usuario Por Token");
        }
        $this->token = $token;
    }
    public function getToken(): string{
        return $this->token;
    }


}