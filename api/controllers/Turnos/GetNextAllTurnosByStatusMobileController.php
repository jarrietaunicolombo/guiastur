<?php

namespace Api\Controllers\Turnos;

use Api\Services\Auth\AuthService;
use Api\Middleware\Authorization\AuthorizationMiddleware;
use Api\Middleware\Response\ResponseMiddleware;
use Api\Services\Turnos\TurnoService;

class GetNextAllTurnosByStatusMobileController
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

            $estado = $request['estado'] ?? null;
            if (!$estado) {
                throw new \InvalidArgumentException("El estado es requerido para filtrar los turnos.");
            }

            $turnos = $this->turnoService->getTurnosByStatus($estado);

            ResponseMiddleware::success(['turnos' => array_map(fn($turno) => $turno->to_array(), $turnos)]);
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
