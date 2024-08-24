<?php

namespace api\controllers\users;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Controllers/CookiesSetup.php";

class LogoutController
{
    public function handleRequest(array $request)
    {
        $isApi = isset($request['is_api']) && $request['is_api'] == 'true';

        if ($request["action"] === "logout") {
            $this->logout($isApi);
        } else {
            $this->sendErrorResponse("Accion Invalida", $isApi);
        }
    }

    private function logout($isApi)
    {
        \SessionUtility::startSession();
        \SessionUtility::clearAllSession();
        unset($_SESSION[\ItemsInSessionEnum::USER_LOGIN]);

        if ($isApi) {
            setcookie("user_id", "", time() - 3600, "/");
            setcookie("user_role", "", time() - 3600, "/");

            echo json_encode(["message" => "Sesión cerrada"]);
            exit();
        } else {
            $_SESSION[\ItemsInSessionEnum::ERROR_MESSAGE] = "Sesion cerrada";
            header("Location: ../../Views/Users/login.php");
            exit();
        }
    }

    private function sendErrorResponse($message, $isApi)
    {
        if ($isApi) {
            header('Content-Type: application/json');
            echo json_encode(['error' => $message]);
            exit;
        } else {
            $_SESSION[\ItemsInSessionEnum::ERROR_MESSAGE] = $message;
            header("Location: ../../Views/Users/login.php");
            exit();
        }
    }
}
