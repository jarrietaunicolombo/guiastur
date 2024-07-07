<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/DependencyInjection.php";

class LoginController
{
    public function handleRequest(array $request)
    {
        $this->login($request);
    }

    private function login(array $request)
    {
        SessionUtility::startSession();
        try {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $request = new LoginRequest($email, $password);
            $loginUseCase = DependencyInjection::getLoginServce();
            $loginResponse = $loginUseCase->login($request);
            $InformationMessage = "Hola " . $loginResponse->getRol() . " " . $loginResponse->getNombre();
            $_SESSION[ItemsInSessionEnum::USER_LOGIN]=$loginResponse;
            $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] = $InformationMessage;
            // $uri = "/Views/index.php";
            // $url = UrlHelper::getUrl($uri);
            // header("Location: $url");
            header("Location: ../../Views/index.php");
        } catch (Exception $e) { 
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
            // $uri = "/Views/Users/login.php";
            // $url = UrlHelper::getUrl($uri);
            header("Location: ../../Views/Users/login.php?ErrorMessage=".$e->getMessage()); 
        }
    }
}

