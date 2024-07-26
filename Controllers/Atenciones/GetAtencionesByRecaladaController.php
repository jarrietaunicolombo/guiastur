<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetAtencionesByRecalada/Dto/GetAtencionesByRecaladaResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetAtencionesByRecalada/Dto/GetAtencionesByRecaladaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/UseCases/IGetAtencionesByRecaladaUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";

class GetAtencionesByRecaladaController
{

    public function handleRequest($request)
    {
        SessionUtility::startSession();
        $accion = @$request["action"];
        if ($accion === "listbyrecalada") {
            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $this->getAtencionesByRecalada($request);
            }
            else{
                $this->showLogin("Accion invalida");
            }
        } else {
            $this->showLogin("Accion invalida");
        }
    }

    private function getAtencionesByRecalada($request)
    {
        try {
            $loginUser = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;
            if ($loginUser === null) {
                throw new InvalidPermissionException();
            }
            $service = DependencyInjection::getAtencionesByRecaladaServce();
            $getAtencionesRequest = new GetAtencionesByRecaladaRequest($request["recalada"]);
            $response = $service->getAtencionesByRecalada($getAtencionesRequest);
            $_SESSION[ItemsInSessionEnum::LIST_ATENCIONES] = $response;
            $_SESSION[ItemsInSessionEnum::CURRENT_PAGE] = $request["page"] ?? "menu";
        } catch (InvalidPermissionException $e) {
            $this->showLogin("Acceso denegado");
        } catch (Exception $e) {
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
        }
        header("Location: ../../Views/Atenciones/listbyrecalada.php?buque=".@$request["buque"]."&recalada=".$request["recalada"]);
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
