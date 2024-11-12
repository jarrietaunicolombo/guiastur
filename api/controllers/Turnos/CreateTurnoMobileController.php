<?php

namespace Api\Controllers\Turnos;

use Api\Services\Auth\AuthService;
use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Services\Turnos\TurnoService;

class CreateTurnoMobileController
{
    private $turnoService;
    private $authService;

    public function __construct()
    {
        $this->turnoService = new TurnoService();
        $this->authService = new AuthService();
    }

    public function handleRequest(array $request)
    {
        try {
            $decodedToken = $this->authService->validateToken($this->getAuthorizationHeader());

            AuthorizationMiddleware::checkRolePermission($decodedToken, ['GUIA']);

            $data = [
                'atencion_id' => $request['atencion_id'],
                'total_turnos' => $request['total_turnos'],
                'observaciones' => $request['observaciones'] ?? null,
                'guia_id' => $decodedToken->data->userId,
                'usuario_registro' => $decodedToken->data->userId
            ];

            $turno = $this->turnoService->createTurno($data);

            ResponseMiddleware::success(['message' => 'Turno creado exitosamente', 'turno' => $turno->to_array()]);
        } catch (\Exception $e) {
            ResponseMiddleware::error($e->getMessage(), $e->getCode() ?: 500);
        }
    }

    private function getAuthorizationHeader()
    {
        $headers = apache_request_headers();
        return $headers['Authorization'] ?? '';
    }
}
