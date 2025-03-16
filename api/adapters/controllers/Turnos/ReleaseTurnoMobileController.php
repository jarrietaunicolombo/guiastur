<?php

namespace Api\Controllers\Turnos;

use Api\Services\Auth\AuthService;
use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Services\Turnos\TurnoService;

class ReleaseTurnoMobileController
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

            AuthorizationMiddleware::checkRolePermission($decodedToken, ['SUPERVISOR', 'GUIA']);

            $turnoId = $request['turno_id'] ?? null;
            if (!$turnoId) {
                throw new \InvalidArgumentException("El ID del turno es requerido para liberarlo.");
            }

            $turno = $this->turnoService->releaseTurno($turnoId, $decodedToken->data->userId);

            ResponseMiddleware::success(['message' => 'Turno liberado exitosamente', 'turno' => $turno->to_array()]);
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
