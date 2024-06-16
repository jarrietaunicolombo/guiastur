<?php
class ConnectionDbException extends Exception
{
    public function __construct($message = "No es posible conectarse al Servidor de Bd, revise los parametros de conexion", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
