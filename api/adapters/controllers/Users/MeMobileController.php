<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Users/UserService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Auth/AuthService.php";

use Api\Services\Auth\AuthService;
use Api\Services\UserService;

class MeMobileController
{
    private $authService;
    private $userService;

    public function __construct()
    {
        $this->authService = new AuthService();
        $this->userService = new UserService();
    }

    public function handleRequest()
    {
        try {
            $userId = $this->authService->getUserIdFromToken();
            $user = $this->userService->getUserById($userId);

            echo json_encode([
                "success" => true,
                "data" => [
                    "id" => $user->id,
                    "nombre" => $user->nombre,
                    "email" => $user->email,
                ]
            ]);
        } catch (\Exception $e) {
            http_response_code(401);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}