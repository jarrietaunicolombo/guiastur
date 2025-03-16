<?php

namespace Api\Exceptions;

use Exception;

class InvalidAtencionException extends Exception
{
    public function __construct($message = "Atención inválida", $code = 400, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
