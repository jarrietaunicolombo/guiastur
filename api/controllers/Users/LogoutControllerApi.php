<?php

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
        $cookies = new CookiesSetup();
        $cookies->clearAuthTokenCookie();

        $this->sendSuccessResponse([
            "message" => "Logout exitoso."
        ]);
    }

    private function sendSuccessResponse($data)
    {
        echo json_encode($data);
        http_response_code(200);
        exit();
    }
}
