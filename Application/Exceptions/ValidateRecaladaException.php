<?php

class ValidateRecaladaException extends Exception {
    public function __construct($message = "El Buque tiene una recalada programada para esta fecha", $code = 0) {
        parent::__construct($message, $code);
    }
}