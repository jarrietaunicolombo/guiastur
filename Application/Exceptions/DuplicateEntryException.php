<?php
class DuplicateEntryException extends Exception
{
    public function __construct($message = "Ya existe un registro previmanete guardado", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
