<?php

class EmailSenderException extends Exception {
    public function __construct($message = "La notificacion por email no pudo ser enviada", $code = 0) {
        parent::__construct($message, $code);
    }
}