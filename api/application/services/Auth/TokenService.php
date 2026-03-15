<?php

namespace Api\Services\Auth;

use Api\Helpers\JWTHandler;
use Api\Models\UserToken;
use Api\Exceptions\UnauthorizedException;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/infrastructure/Helpers/JWTHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/Exceptions/UnauthorizedException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/UserToken.php";

class TokenService
{
    public function refreshToken($refreshToken)
    {
        $userToken = UserToken::find('first', ['conditions' => ['token = ? AND expira_el > NOW()', $refreshToken]]);
        if (!$userToken) {
            throw new UnauthorizedException("Refresh token no válido o expirado.");
        }

        return $userToken;
    }

    public function createAuthToken($usuario, $rol)
    {
        $tokenData = [
            'userId' => $usuario->id,
            'role' => $rol->nombre
        ];

        return JWTHandler::createToken($tokenData);
    }
}
