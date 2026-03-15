<?php

namespace Api\Exceptions;

use Exception;

class ValidationException extends Exception
{
    public function __construct($message = "Datos no válidos.", $code = 422)
    {
        parent::__construct($message, $code);
    }
}
