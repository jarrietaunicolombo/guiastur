<?php
class LoginRequest{

    private  $email;
    private  $password;

    public function __construct(string $email, string $password)
    {
       
        if(!isset($email) || empty(trim($email))){
            throw new \InvalidArgumentException("El Email debe es requerido");
        }
        if(!isset($password) || empty(trim($password))){
            throw new \InvalidArgumentException("El Password debe es requerido");
        }
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): string{
        return $this->email;
    }

    public function getPassword(): string{
        return $this->password;
    }
}
