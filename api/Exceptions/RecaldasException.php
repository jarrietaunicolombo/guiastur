<?php

namespace Api\Exceptions;

use Exception;

class RecaladasException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = "Error en la operación de recaladas", $code = 500)
    {
        parent::__construct($message, $code);
    }

}
