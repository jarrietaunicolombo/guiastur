<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencion/Dto/GetTurnosByAtencionResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencion/Dto/GetTurnosByAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetAtenciones/Dto/GetAtencionByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetAtenciones/Dto/GetAtencionResponse.php";
// require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/IGetTurnosByAtencionUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/DependencyInjection.php";

class GetTurnosByAtencionController
{

    public function handleRequest($request)
    {
        SessionUtility::startSession();
        $accion = @$request["action"];
        if ($accion === "listbyatencion") {
            if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $this->getTurnosByAtencion($request);
            }
            else{
                $this->showLogin("Accion invalida");
            }
        } else {
            $this->showLogin("Accion invalida");
        }
    }

    private function GetTurnosByAtencion($request)
    {
        try {
            $loginUser = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;
            if ($loginUser === null) {
                throw new InvalidPermissionException("No tiene permisos para crear Turnos");
            }
            if (!isset($request["atencion"]) || @$request["atencion"] < 1) {
                throw new InvalidArgumentException("Se requiere una atención para esta operación");
            }
            $atencionRequest = new GetAtencionByIdRequest($request["atencion"]);
            $atencionQuery = DependencyInjection::getAtencionByIdQuery();
            $atencionResponse = $atencionQuery->handler($atencionRequest);
            $_SESSION[ItemsInSessionEnum::FOUND_ATENCION] = $atencionResponse;
            $service = DependencyInjection::GetTurnosByAtencionServce();
            $getTurnosByAtencionRequest = new GetTurnosByAtencionRequest($request["atencion"]);
            $response = $service->getTurnosByAtencion($getTurnosByAtencionRequest);
            $_SESSION[ItemsInSessionEnum::LIST_TURNOS] = $response;
        } catch (InvalidPermissionException $e) {
            $this->showLogin($e->getMessage());
        } catch (Exception $e) {
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
        }
        header("Location: ../../Views/Turnos/list.php");
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
