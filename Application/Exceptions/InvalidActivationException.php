<?php
class InvalidActivationException extends Exception
{
    public function __construct($message = "El usuario ya se encuentra activo", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
