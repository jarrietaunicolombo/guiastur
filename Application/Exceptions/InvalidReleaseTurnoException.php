<?php

class InvalidReleaseTurnoException extends Exception {
    public function __construct($message = "El Turno no esta en eso", $code = 0) { 
        parent::__construct($message, $code);
    }
}