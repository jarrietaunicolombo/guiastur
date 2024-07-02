<?php
class EntityReferenceNotFoundException extends Exception
{
    public function __construct($message = "Esta entidad depende de la referecia de otra entidad", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
