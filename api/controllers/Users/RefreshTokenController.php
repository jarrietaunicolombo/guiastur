<?php

namespace Api\Controllers\Users;

use Api\Services\UserService;
use Api\Services\ResponseService;
use Api\Services\Auth\TokenService;
use Api\Helpers\CookiesSetup;
use Api\Exceptions\UnauthorizedException;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Auth/TokenService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/Users/UserService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/services/HTTP/ResponseService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/CookiesSetup.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Exceptions/UnauthorizedException.php";

class RefreshTokenController
{
    private $tokenService;
    private $userService;
    private $responseService;

    public function __construct()
    {
        $this->tokenService = new TokenService();
        $this->userService = new UserService();
        $this->responseService = new ResponseService();
    }

    public function handleRequest()
    {
        error_log("[INFO] handleRequest llamado");

        $data = json_decode(file_get_contents("php://input"), true);
        $refreshToken = $data['refresh_token'] ?? $_COOKIE['refresh_token'] ?? null;

        error_log("[INFO] Token de refresco recibido: " . ($refreshToken ? $refreshToken : 'No token'));

        if (!$refreshToken) {
            error_log("[ERROR] No se proporcionó token de refresco");
            $this->responseService->sendErrorResponse('Falta el token de refresco', 400);
            return;
        }

        $this->refreshToken($refreshToken);
    }

    private function refreshToken($refreshToken)
    {
        try {
            error_log("[INFO] Intentando refrescar el token: " . $refreshToken);

            $userToken = $this->tokenService->refreshToken($refreshToken);
            if (!$userToken) {
                error_log("[ERROR] Token de refresco no válido o expirado");
                throw new UnauthorizedException("Refresh token no válido o expirado.");
            }

            error_log("[INFO] Token refrescado exitosamente para el usuario: " . $userToken->usuario_id);
            $usuario = $this->userService->getUsuario($userToken->usuario_id);
            $rol = $this->userService->getUsuarioRol($usuario->rol_id);

            if (!$usuario || !$rol) {
                error_log("[ERROR] Usuario o rol no encontrado");
                throw new UnauthorizedException("Usuario o rol no encontrado.");
            }

            $newAuthToken = $this->tokenService->createAuthToken($usuario, $rol);
            error_log("[INFO] Nuevo token generado: " . $newAuthToken);

            $cookies = new CookiesSetup();
            $cookies->setAuthTokenCookie($newAuthToken);

            $this->responseService->sendSuccessResponse([
                "message" => "Token refrescado exitosamente.",
                "token" => $newAuthToken
            ]);
        } catch (UnauthorizedException $e) {
            ob_end_clean();
            error_log("[ERROR] " . $e->getMessage());
            $this->responseService->sendErrorResponse($e->getMessage(), 401);
        } catch (\Exception $e) {
            ob_end_clean();
            error_log("[ERROR] Error general al refrescar el token: " . $e->getMessage());
            $this->responseService->sendErrorResponse("Error al refrescar el token: " . $e->getMessage(), 400);
        }
    }
}
