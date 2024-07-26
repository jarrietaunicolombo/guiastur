<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladas/Dto/GetRecaladasResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/UseCases/IGetRecaladasService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";

class GetRecaladasController
{

    public function handleRequest($request)
    {
        SessionUtility::startSession();
        $accion = @$request["action"];
        if ($accion === "listall") {
            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $this->getRecaladas($request);
            }
            else{
                $this->showLogin("Accion invalida");
            }
        } else {
            $this->showLogin("Accion invalida");
        }
    }

    private function getRecaladas($request)
    {
        try {
            $loginUser = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;
            if ($loginUser === null) {
                throw new InvalidPermissionException();
            }
            $service = DependencyInjection::getRecaladasService();
            $response = $service->getRecaladas();
            $_SESSION[ItemsInSessionEnum::LIST_RECALADAS] = $response;
        } catch (InvalidPermissionException $e) {
            $this->showLogin("Acceso denegado");
        } catch (Exception $e) {
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
        }
        header("Location: ../../Views/Recaladas/listall.php");
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
