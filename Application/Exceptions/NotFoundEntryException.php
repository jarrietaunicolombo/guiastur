<?php
class NotFoundEntryException extends Exception
{
    public function __construct($message = "El registro no existe", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
