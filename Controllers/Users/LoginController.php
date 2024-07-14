<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/DependencyInjection.php";

class LoginController
{
    public function handleRequest(array $request)
    {
        if($request["action"] === "login")$this->login($request);
        if($request["action"] === "logout")$this->logout();
    }

    private function login(array $request)
    {
        SessionUtility::startSession();
        try {
            SessionUtility::clearAllSession();

            $email = $_POST['email'];
            $password = $_POST['password'];
            $request = new LoginRequest($email, $password);
            $loginUseCase = DependencyInjection::getLoginServce();
            $loginResponse = $loginUseCase->login($request);
            $InformationMessage = "Hola " . $loginResponse->getRol() . " " . $loginResponse->getNombre();
            SessionUtility::startSession();
            $_SESSION[ItemsInSessionEnum::USER_LOGIN]=$loginResponse;
            $_SESSION[ItemsInSessionEnum::WELCOME_MESSAGE] = $InformationMessage;
            header("Location: ../../Views/index.php");
        } catch (Exception $e) { 
            SessionUtility::clearAllSession();
            SessionUtility::startSession();
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
            header("Location: ../../Views/Users/login.php"); 
        }
    }

    private function logout (){
        SessionUtility::clearAllSession();
        SessionUtility::startSession();
        unset($_SESSION[ItemsInSessionEnum::USER_LOGIN]);
        $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = "Sesion cerrada";
        header("Location: ../../Views/Users/login.php"); 
    }
}

