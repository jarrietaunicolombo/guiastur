<?php
class InvalidRequestParameterException extends Exception 
{   
    public function __construct($message = "Parametros de peiticion incorrectos", $code = 0)
    {
        parent::__construct($message, $code);
    }
}