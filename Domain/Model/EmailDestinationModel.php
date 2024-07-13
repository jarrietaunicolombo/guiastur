<?php

class EmailDestinationModel{
    private $destinationEmail;
    private $destinationName;
    private $subject;
    private $body;

    public function __construct(string $destinationEmail
                    , string $destinationName
                    , string $subject
                    , string $body)
    {
        if($destinationEmail === null || empty(trim($destinationEmail))){
            throw new \InvalidArgumentException("El Email del destinatario es requerido para enviar la notificacion");
        }

        if($destinationName === null || empty(trim($destinationName))){
            throw new \InvalidArgumentException("El Nombre del destinatario es requerido para enviar la notificacion");
        }

        if($subject === null || empty(trim($subject))){
            throw new \InvalidArgumentException("El Asunto es requerido para enviar la notificacion");
        }
        
        if($body === null || empty(trim($body))){
            throw new \InvalidArgumentException("El Cuerpo del mensaje es requerido para enviar la notificacion");
        }

        $this->destinationEmail = $destinationEmail;
        $this->destinationName = $destinationName;
        $this->subject = $subject;
        $this->body = $body;
        
    }

    public function getDestinationEmail(): string
    {
        return $this->destinationEmail;
    }

    public function getDestinationName(): string
    {
        return $this->destinationName;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }
    public function getBody(): string
    {
        return $this->body;
    }

}