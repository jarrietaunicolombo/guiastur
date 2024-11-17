<?php

namespace Api\Controllers\Users;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/CookiesSetup.php";

use Api\Helpers\CookiesSetup;

class LogoutController
{
    public function handleRequest()
    {
        $this->logout();
    }

    private function logout()
    {
        ob_start();

        $cookies = new CookiesSetup();

        $cookies->clearAuthTokenCookie();
        $cookies->clearRefreshTokenCookie();

        ob_end_clean();

        $this->sendSuccessResponse(["message" => "Logout exitoso."]);
    }

    private function sendSuccessResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        http_response_code(200);
        exit();
    }
}
