<?php

class InvalidEndTurnoException extends Exception {
    public function __construct($message = "El Turno no está liberado", $code = 0) { 
        parent::__construct($message, $code);
    }
}