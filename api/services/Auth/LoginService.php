<?php

namespace Api\Services\Auth;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginRequest.php";

use Api\Exceptions\UnauthorizedException;

class LoginService
{
    public function login(string $email, string $password)
    {
        $loginRequest = new \LoginRequest($email, $password);
        $loginUseCase = \DependencyInjection::getLoginServce();
        $loginResponse = $loginUseCase->login($loginRequest);

        if (!$loginResponse) {
            throw new UnauthorizedException("Credenciales incorrectas.");
        }

        return $loginResponse;
    }
}
