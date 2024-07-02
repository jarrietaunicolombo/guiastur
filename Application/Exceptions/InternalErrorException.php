<?php
class InternalErrorException extends Exception
{
    public function __construct($message = "Ocurrio un error interno desconocido", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
