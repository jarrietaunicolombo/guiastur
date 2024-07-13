<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetBuques/Dto/GetBuquesResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/IGetBuquesService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/DependencyInjection.php";

class GetBuquesController
{

    public function handleRequest($request)
    {
        SessionUtility::startSession();
        $action = @$request["action"];
        if (!isset($action) || $action != "listall") {
            SessionUtility::clearAllSession();
            SessionUtility::startSession();
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = "Accion Invalida";
            header("Location: ../../Views/Users/login.php");
            exit;
        }
        $this->getBuques($request);
    }

    public function getBuques($request)
    {
        try {
            $loginUser = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;
            if ($loginUser === null) {
                throw new InvalidPermissionException();
            }

            $service = DependencyInjection::getBuquesService();
            $response = $service->getBuques();
            $_SESSION[ItemsInSessionEnum::LIST_BUQUES] = $response;

        } catch (InvalidPermissionException $e) {
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
            SessionUtility::clearAllSession();
            SessionUtility::startSession();
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
            header("Location: ../../Views/Users/login.php");
            exit;
        } catch (Exception $e) {
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
        }
        header("Location: ../../Views/Buques/list.php");
    }

}
