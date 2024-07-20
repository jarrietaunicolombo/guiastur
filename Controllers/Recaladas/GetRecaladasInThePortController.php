<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRecaladasInThePort/Dto/GetRecaladasInThePortResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/IGetRecaladasInThePortUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/DependencyInjection.php";

class GetRecaladasInThePortController
{

    public function handleRequest($request)
    {
        SessionUtility::startSession();
        $accion = @$request["action"];
        if ($accion === "listinport") {
            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $this->getRecaladasInThePort($request);
            }
            else{
                $this->showLogin("Accion invalida");
            }
        } else {
            $this->showLogin("Accion invalida");
        }
    }

    private function getRecaladasInThePort($request)
    {
        try {
            $loginUser = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;
            if ($loginUser === null) {
                throw new InvalidPermissionException();
            }
            $service = DependencyInjection::getRecaladasInThePortServce();
            $response = $service->getRecaladasInThePort();
            $_SESSION[ItemsInSessionEnum::LIST_RECALADAS] = $response;
        } catch (InvalidPermissionException $e) {
            $this->showLogin("Acceso denegado");
        } catch (Exception $e) {
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
        }
        header("Location: ../../Views/Recaladas/listinport.php");
    }


    private function showLogin(string $message)
    {
        SessionUtility::clearAllSession();
        SessionUtility::startSession();
        $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $message;
        header("Location: ../../Views/Users/login.php");
        exit;
    }
}
