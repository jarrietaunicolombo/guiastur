<?php

class InvalidPermissionException extends Exception {
    public function __construct($message = "Usted no tiene permisos para realizar esta accion", $code = 0) {
        parent::__construct($message, $code);
    }
}