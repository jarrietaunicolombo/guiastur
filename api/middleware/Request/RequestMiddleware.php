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

    public static function validateCreateRecaladaRequest($request)
    {
        $errorMessages = [];

        if (!isset($request['buque_id']) || $request['buque_id'] < 1) {
            $errorMessages['buque_id'] = 'El Buque es requerido y debe ser mayor que 0.';
        }

        if (!isset($request['pais_id']) || $request['pais_id'] < 1) {
            $errorMessages['pais_id'] = 'El País es requerido y debe ser mayor que 0.';
        }

        if (!isset($request['fecha_arribo'])) {
            $errorMessages['fecha_arribo'] = 'La Fecha de Arribo es requerida.';
        } else {
            $fecha_arribo = \DateTime::createFromFormat('Y-m-d\TH:i', $request['fecha_arribo']);
            if ($fecha_arribo === false) {
                $errorMessages['fecha_arribo'] = 'La Fecha de Arribo debe tener el formato AAAA-MM-DDTHH:MM.';
            }
        }

        if (!isset($request['fecha_zarpe'])) {
            $errorMessages['fecha_zarpe'] = 'La Fecha de Zarpe es requerida.';
        } else {
            $fecha_zarpe = \DateTime::createFromFormat('Y-m-d\TH:i', $request['fecha_zarpe']);
            if ($fecha_zarpe === false) {
                $errorMessages['fecha_zarpe'] = 'La Fecha de Zarpe debe tener el formato AAAA-MM-DDTHH:MM.';
            }
        }

        if (isset($fecha_arribo) && isset($fecha_zarpe) && $fecha_arribo > $fecha_zarpe) {
            $errorMessages['fechas'] = 'La Fecha de Arribo no puede ser mayor que la Fecha de Zarpe.';
        }

        if (!isset($request['total_turistas']) || $request['total_turistas'] < 1) {
            $errorMessages['total_turistas'] = 'El número total de turistas es requerido y debe ser mayor que 0.';
        }

        if (count($errorMessages) > 0) {
            error_log("Errores de validación: " . json_encode($errorMessages)); // Log de errores
            throw new \InvalidArgumentException(json_encode($errorMessages));
        }
    }

        public static function validateCreateAtencionRequest($request)
        {
            $errorMessages = [];

            if (!isset($request['observaciones']) || strlen($request['observaciones']) < 3) {
                $errorMessages['observaciones'] = 'Las observaciones son requeridas y deben tener al menos 3 caracteres.';
            }

            if (!isset($request['supervisor_id']) || $request['supervisor_id'] < 1) {
                $errorMessages['supervisor_id'] = 'El ID del supervisor es requerido y debe ser mayor que 0.';
            }

            if (!isset($request['recalada_id']) || $request['recalada_id'] < 1) {
                $errorMessages['recalada_id'] = 'El ID de la recalada es requerido y debe ser mayor que 0.';
            }

            if (count($errorMessages) > 0) {
                error_log("Errores de validación: " . json_encode($errorMessages)); // Registro de los errores
                throw new \InvalidArgumentException(json_encode($errorMessages));
            }
        }
}
