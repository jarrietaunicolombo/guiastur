<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/JWTHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/CookiesSetup.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/UserToken.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Exceptions/UnauthorizedException.php";

use Api\Helpers\JWTHandler;
use Api\Helpers\CookiesSetup;
use Api\Exceptions\UnauthorizedException;
use Api\Models\UserToken;

class RefreshTokenController
{
    public function handleRequest()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $refreshToken = $data['refresh_token'] ?? $_COOKIE['refresh_token'] ?? null;

        if (!$refreshToken) {
            http_response_code(400);
            echo json_encode(['error' => 'Falta el token de refresco']);
            return;
        }

        $this->refreshToken($refreshToken);
    }

    private function refreshToken($refreshToken)
    {
        try {
            ob_start();

            $userToken = UserToken::find('first', ['conditions' => ['token = ? AND expira_el > NOW()', $refreshToken]]);
            if (!$userToken) {
                error_log("Refresh token no válido o expirado.");
                throw new UnauthorizedException("Refresh token no válido o expirado.");
            }

            $usuario = $this->getUsuario($userToken->usuario_id);
            $rol = $this->getUsuarioRol($usuario->rol_id);
            if (!$usuario || !$rol) {
                throw new UnauthorizedException("Usuario o rol no encontrado.");
            }

            $tokenData = [
                'userId' => $usuario->id,
                'role' => $rol->nombre
            ];

            $newAuthToken = JWTHandler::createToken($tokenData);
            error_log("Nuevo auth token generado: " . $newAuthToken);

            $cookies = new CookiesSetup();
            $cookies->setAuthTokenCookie($newAuthToken);

            ob_end_clean();

            $this->sendSuccessResponse([
                "message" => "Token refrescado exitosamente.",
                "token" => $newAuthToken
            ]);
        } catch (UnauthorizedException $e) {
            ob_end_clean();
            error_log("Error en el refresco del token: " . $e->getMessage());
            $this->sendErrorResponse($e->getMessage(), 401);
        } catch (\Exception $e) {
            ob_end_clean();
            error_log("Error general en el refresco del token: " . $e->getMessage());
            $this->sendErrorResponse("Error al refrescar el token: " . $e->getMessage(), 400); // Respuesta de error genérico 400
        }
    }

    private function getUsuario($usuario_id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $usuarios = UserToken::find_by_sql($sql, [$usuario_id]);
        return $usuarios ? $usuarios[0] : null;
    }

    private function getUsuarioRol($rol_id)
    {
        $sql = "SELECT * FROM Rols WHERE id = ?";
        $roles = UserToken::find_by_sql($sql, [$rol_id]);
        return $roles ? $roles[0] : null;
    }

    private function sendSuccessResponse($data)
    {
        error_log("Enviando respuesta de éxito: " . print_r($data, true));
        http_response_code(200);
        echo json_encode($data);
        exit();
    }

    private function sendErrorResponse($message, $code = 400)
    {
        error_log("Enviando respuesta de error: " . $message);
        http_response_code($code);
        echo json_encode(["error" => $message]);
        exit();
    }
}
