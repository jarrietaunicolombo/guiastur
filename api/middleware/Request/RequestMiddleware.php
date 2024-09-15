<?php

namespace Api\Middleware\Request;

class RequestMiddleware
{
    public static function validateCreateUserRequest($request)
    {
        if (!isset($request['email']) || !isset($request['nombre']) || !isset($request['rol_id'])) {
            throw new \InvalidArgumentException('El Email, Nombre y Rol son requeridos.');
        }

        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException('El Email no es válido.');
        }

        if (strlen($request['nombre']) < 3) {
            throw new \InvalidArgumentException('El Nombre debe tener al menos 3 caracteres.');
        }
    }

    public static function validateCreateBuqueRequest($request)
    {
        if (!isset($request['codigo']) || !isset($request['nombre'])) {
            throw new \InvalidArgumentException('El Código y el Nombre son requeridos.');
        }

        if (strlen($request['codigo']) < 2 || strlen($request['codigo']) > 30) {
            throw new \InvalidArgumentException('El Código debe tener entre 2 y 30 caracteres.');
        }

        if (!preg_match('/^[a-zA-Z0-9]+$/', $request['codigo'])) {
            throw new \InvalidArgumentException('El Código solo puede contener letras y números.');
        }

        if (strlen($request['nombre']) < 3 || strlen($request['nombre']) > 100) {
            throw new \InvalidArgumentException('El Nombre debe tener entre 3 y 100 caracteres.');
        }

        if (!preg_match('/^[a-zA-Z0-9\s]+$/', $request['nombre'])) {
            throw new \InvalidArgumentException('El Nombre solo puede contener letras y espacios.');
        }
    }
}
