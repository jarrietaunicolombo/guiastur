<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladas/Dto/GetRecaladasResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateAtencion/Dto/CreateAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetAtencionesByRecalada/Dto/GetAtencionesByRecaladaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/UseCases/IGetAtencionesByRecaladaUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";

class CreateAtencionController
{

    public function handleRequest($request)
    {
        SessionUtility::startSession();
        $accion = @$request["action"];
        if ($accion === "create") {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->createAtencion($request);
            } else if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $this->showFormCreate($request);
            } else {
                $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = "Accion Invalida";
                $errorResponse = ["error" => "Accion invalida"];
                echo json_encode($errorResponse);
                exit;
            }
        } else {
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = "Accion Invalida";
            $errorResponse = ["error" => "Accion invalida"];
            echo json_encode($errorResponse);
            exit;
        }
    }

    private function createAtencion($request)
    {
        try {
            $loginUser = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;
            if ($loginUser === null) {
                throw new InvalidPermissionException("No tiene permisos para crear Atenciones");
            }

            $recalada = @$_SESSION[ItemsInSessionEnum::FOUND_RECALADA] ?? null;
            if ($recalada) {
                new InvalidArgumentException("La Recalada es requida");
            }

            $errorMessages = [];

            if (!isset($request["supervisor_id"]) || $request["supervisor_id"] < 1) {
                $errorMessages["supervisor"] = "Es requerido";
            }

            $fecha_inicio = DateTime::createFromFormat("Y-m-d\TH:i", @$request["fecha_inicio"]);
            if ($fecha_inicio === false) {
                $errorMessages["inicio"] = "Formato: YYYY-MM-DD HH:MM:SS";
            }

            if ($fecha_inicio < $recalada->getFechaArribo()) {
                $errorMessages["inicio"] = "Menor que la fecha de arribo";
            }

            if ($fecha_inicio > $recalada->getFechaZarpe()) {
                $errorMessages["inicio"] = "Mayor que la fecha de zarpe";
            }

            $fecha_cierre = DateTime::createFromFormat("Y-m-d\TH:i", @$request["fecha_cierre"]);
            if ($fecha_cierre === false) {
                $errorMessages["cierre"] = "Formato: YYYY-MM-DD HH:MM:SS";
            }

            if ($fecha_cierre < $recalada->getFechaArribo()) {
                $errorMessages["cierre"] = "Menor que la fecha de arribo";
            }
            $cierre = $fecha_cierre->format("Y-m-d H:i:s");
            $zarpe = $recalada->getFechaZarpe()->format("Y-m-d H:i:s");
            if ($fecha_cierre > $recalada->getFechaZarpe()) {
                $errorMessages["cierre"] = "Mayor que la fecha de zarpe";
            }
        
            if ($fecha_inicio > $fecha_cierre) {
                $errorMessages["inicio"] = "Mayor que la fecha de cierre".
                $errorMessages["cierre"] = "Menor que la fecha de inicio";
            }

            if ($fecha_cierre < new DateTime()) {
                $errorMessages["cierre"] = "no puede ser menor que la fecha actual";
            }

            if (!isset($request["total_turnos"]) || $request["total_turnos"] < 1) {
                $errorMessages["turnos"] = "Es requerido";
            }

            if (count($errorMessages) > 0) {
                $errorMessages["error"] = "Datos mal diligenciados";
                echo json_encode($errorMessages);
                exit;
            }

            $observaciones = $request["observaciones"] ?? null;
            $recalada_id = $recalada->getRecaladaId();
            $usurio_id = $loginUser->getId();
            $createAtencionRequest = new CreateAtencionRequest(
                $fecha_inicio,
                $fecha_cierre,
                $request["total_turnos"],
                $observaciones,
                $request["supervisor_id"],
                $recalada_id,
                $usurio_id
            );
            $service = DependencyInjection::getCreateAtencionService();
            $response = $service->createAtencion($createAtencionRequest);
            $_SESSION[ItemsInSessionEnum::CURRENT_PAGE] = $request["page"] ?? "menu";
            echo $response->toJSON();
            exit;

        } catch (Exception $e) {
            $error = ["error" => $e->getMessage()];
            echo json_encode($error);
            exit;
        }
    }

    public function showFormCreate(array $request)
    {
        $recalada_id = @$request["recalada"] ?? null;
        if ($recalada_id !== null && $recalada_id > 0) {
            $recalada = (DependencyInjection::getRecaladaByIdQuery())->handler(new GetRecaladaByIdRequest($recalada_id));
            $_SESSION[ItemsInSessionEnum::FOUND_RECALADA] = $recalada;
        }
        $supervisores = (DependencyInjection::getSupervisoresQuery())->handler();
        $_SESSION[ItemsInSessionEnum::LIST_SUPERVISORES] = $supervisores;
        header("Location: ../../Views/Atenciones/create.php?recalada=$recalada_id");
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
