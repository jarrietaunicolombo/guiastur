<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateRecalada/Dto/CreateRecaladaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateRecalada/Dto/CreateRecaladaResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetBuques/Dto/GetBuquesResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetPaises/Dto/GetPaisesResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ICreateRecaladaUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetBuquesQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetPaisesQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/ConnectionDbException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/InternalErrorException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/InvalidRequestParameterException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/DependencyInjection.php";

class CreateRecaladaController
{

    public function handleRequest($request)
    {
        SessionUtility::startSession();
        $accion = @$request["action"];
        if ($accion === "create") {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->createRecalada($request);
            } else if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $this->showFormCreateRecalada();
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

    private function createRecalada(array $request)
    {
        try {
            $loginUser = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;
            if ($loginUser === null) {
                throw new InvalidPermissionException("No tiene permisos para crear Buques");
            }

            $errorMessages = array();
            if (!isset($request["buque_id"]) || $request["buque_id"] < 1) {
                $errorMessages["buque"] = "Es requerido";
            }

            if (!isset($request["pais_id"]) || $request["pais_id"] < 1) {
                $errorMessages["pais"] = "Es requerido";
            }

            if (!isset($request["fecha_arribo"])) {
                $errorMessages["arribo"] = "Es requerida";
            }

            if (!isset($request["fecha_zarpe"])) {
                $errorMessages["zarpe"] = "Es requerida";
            }

            $fecha_arribo = DateTime::createFromFormat("Y-m-d\TH:i", $request["fecha_arribo"]);
            if ($fecha_arribo === false) {
                $errorMessages["arribo"] = "Formato: AAAA-MM-DDD";
            }

            $fecha_zarpe = DateTime::createFromFormat("Y-m-d\TH:i", $request["fecha_zarpe"]);
            if ($fecha_zarpe === false) {
                $errorMessages["zarpe"] = "Formato: AAAA-MM-DDD";
            }

            if ($fecha_zarpe < new DateTime()) {
                $errorMessages["zarpe"] = "Incorrecta";
            }


            if ($fecha_zarpe < new DateTime()) {
                $errorMessages["zarpe"] = "Incorrecta";
            }

            if ($fecha_arribo > $fecha_zarpe) {
                $errorMessages["arribo"] = "Mayor que la fecha de zarpe";
                $errorMessages["zarpe"] = "Menor que la fecha de arribo";
            }

            if (!isset($request["total_turistas"]) || $request["total_turistas"] < 1) {
                $errorMessages["turistas"] = "Es requerido";
            }

            if (count($errorMessages) > 0) {
                $errorMessages["error"] = "Datos mal diligenciados";
                echo json_encode($errorMessages);
                exit;
            }

            $total_turistas = $request["total_turistas"];
            $buque_id = $request["buque_id"];
            $pais_id = $request["pais_id"];
            $observaciones = $request["observaciones"] ?? null;
            $usuario_registro = $loginUser->getId();
            $createRecaladaRequest = new CreateRecaladaRequest(
                $fecha_arribo,
                $fecha_zarpe,
                $total_turistas,
                $observaciones,
                $buque_id,
                $pais_id,
                $usuario_registro
            );
            $service = DependencyInjection::getCreateRecaladaServce();
            $createRecaladaResponse = $service->createRecalada($createRecaladaRequest);
            echo $createRecaladaResponse->toJson();
            exit;
        } catch (Exception $e) {
            $error = ["error" => $e->getMessage()];
            echo json_encode($error);
            exit;
        }
    }


    private function showFormCreateRecalada()
    {
        try {
            $buquesServices = DependencyInjection::getBuquesService();
            $paisesService = DependencyInjection::getPaisesServce();
            $buquesResponse = $buquesServices->getBuques();
            $paisesResponse = $paisesService->getPaises();
            $_SESSION[ItemsInSessionEnum::LIST_BUQUES] = $buquesResponse;
            $_SESSION[ItemsInSessionEnum::LIST_PAISES] = $paisesResponse;
        } catch (Exception $e) {
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
        }
        header("Location: ../../Views/Recaladas/create.php");
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

