<?php
class NumberTurnosExceededException extends Exception {
    public function __construct($message = "No hay turnos disponibles para esta Atencion", $code = 508) {
        parent::__construct($message, $code);
    }
}