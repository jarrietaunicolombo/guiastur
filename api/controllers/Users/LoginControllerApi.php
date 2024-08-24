<?php

namespace api\controllers\users;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Controllers/CookiesSetup.php";

class LoginController
{
    public function handleRequest(array $request)
    {
        $isApi = isset($request['is_api']) && $request['is_api'] == 'true';

        if ($request["action"] === "login") {
            $this->login($request, $isApi);
        } else {
            $this->sendErrorResponse("Accion Invalida", $isApi);
        }
    }

    private function login(array $request, $isApi)
    {
        \SessionUtility::startSession();
        try {
            \SessionUtility::startSession();

            if (empty($request['email']) || empty($request['password'])) {
                throw new \Exception("Email y password son requeridos.");
            }

            $email = $request['email'];
            $password = $request['password'];
            $loginRequest = new \LoginRequest($email, $password);
            $loginUseCase = \DependencyInjection::getLoginServce();
            $loginResponse = $loginUseCase->login($loginRequest);

            $userId = $loginResponse->getId();
            $userRole = $loginResponse->getRol();

            $InformationMessage = "Hola " . $userRole . " " . $loginResponse->getNombre();
            \SessionUtility::startSession();
            $_SESSION[\ItemsInSessionEnum::USER_LOGIN] = $loginResponse;
            $_SESSION[\ItemsInSessionEnum::WELCOME_MESSAGE] = $InformationMessage;

            if ($isApi) {
                setupCookies($userId, $userRole);
                echo json_encode([
                    "message" => "Login exitoso",
                    "user" => [
                        "nombre" => $loginResponse->getNombre(),
                        "rol" => $userRole
                    ]
                ]);
                exit();
            } else {
                header("Location: ../../Views/index.php");
                exit();
            }
        } catch (\Exception $e) {
            \SessionUtility::clearAllSession();
            \SessionUtility::startSession();

            if ($isApi) {
                echo json_encode(["error" => $e->getMessage()]);
                exit();
            } else {
                $_SESSION[\ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
                header("Location: ../../Views/Users/login.php");
                exit();
            }
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
