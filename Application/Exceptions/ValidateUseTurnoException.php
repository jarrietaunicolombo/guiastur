<?php

class ValidateUseTurnoException extends Exception {
    public function __construct($message = "El Turno a usar no corresponde al Proximo Turno", $code = 0) {
        parent::__construct($message, $code);
    }
}