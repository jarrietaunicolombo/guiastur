<?php

namespace Api\Controllers\Turnos;

use Api\Services\Auth\AuthService;
use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Services\Turnos\TurnoService;

class UseTurnoMobileController
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
            $atencionId = $request['atencion_id'] ?? null;
            if (!$turnoId || !$atencionId) {
                throw new \InvalidArgumentException("Los IDs de turno y atención son requeridos para usar el turno.");
            }

            $turno = $this->turnoService->useTurno($turnoId, $atencionId, $decodedToken->data->userId);

            ResponseMiddleware::success(['message' => 'Turno marcado como en uso exitosamente', 'turno' => $turno->to_array()]);
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
