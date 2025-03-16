<?php

namespace Api\Exceptions;

use Exception;

class DuplicateEntryException extends Exception
{
    public function __construct($message = "Registro duplicado", $code = 409, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
