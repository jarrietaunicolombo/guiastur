<?php

class InvalidAtencionException extends Exception {
    public function __construct($message = "Atencion solapada por fecha con otra atencion", $code = 0) {
        parent::__construct($message, $code);
    }
}