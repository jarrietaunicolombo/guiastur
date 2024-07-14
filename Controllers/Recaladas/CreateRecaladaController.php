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
                $this->showLogin("Accion invalida");
            }
        } else {
            $this->showLogin("Accion invalida");
        }
    }

    private function createRecalada(array $request)
    {
        try {

            $loginUser = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;
            if ($loginUser === null) {
                throw new InvalidPermissionException();
            }

            $errorMessages = array();
            if (!isset($request["buque_id"]) || $request["buque_id"] < 1) {
                $errorMessages["buque_id"] = "Es requerido";
            }

            if (!isset($request["pais_id"]) || $request["pais_id"] < 1) {
                $errorMessages["pais_id"] = "Es requerido";
            }

            if (!isset($request["fecha_arribo"])) {
                $errorMessages["fecha_arribo"] = "Es requerida";
            }

            if (!isset($request["fecha_zarpe"])) {
                $errorMessages["fecha_zarpe"] = "Es requerida";
            }

            $fecha_arribo = DateTime::createFromFormat("Y-m-d\TH:i", $request["fecha_arribo"]);
            if ($fecha_arribo === false) {
                $errorMessages["fecha_arribo"] = "Formato: AAAA-MM-DDD";
            }

            $fecha_zarpe = DateTime::createFromFormat("Y-m-d\TH:i", $request["fecha_zarpe"]);
            if ($fecha_zarpe === false) {
                $errorMessages["fecha_zarpe"] = "Formato: AAAA-MM-DDD";
            }

            if ($fecha_zarpe < new DateTime()) {
                $errorMessages["fecha_zarpe"] = "Incorrecta";
            }


            if ($fecha_zarpe < new DateTime()) {
                $errorMessages["fecha_zarpe"] = "Incorrecta";
            }

            if ($fecha_arribo > $fecha_zarpe) {
                $errorMessages["fecha_arribo"] = "Mayor que la fecha de zarpe";
                $errorMessages["fecha_zarpe"] = "Menor que la fecha de arribo";
            }

            if (!isset($request["total_turistas"]) || $request["total_turistas"] < 1) {
                $errorMessages["total_turistas"] = "Es requerido";
            }

            if (count($errorMessages) > 0) {
                throw new InvalidRequestParameterException();
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
            $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] = "Recalada Creada Id: " . $createRecaladaResponse->getId();
            SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGE);
            SessionUtility::deleteItemInSession(ItemsInSessionEnum::ERROR_MESSAGES);
            SessionUtility::deleteItemInSession(ItemsInSessionEnum::RECALADA_REQUEST_CREATING);
            header("Location: ../../Views/Recaladas/create.php");
        } catch (InvalidRequestParameterException $e) {
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGES] = $errorMessages;
            $_SESSION[ItemsInSessionEnum::RECALADA_REQUEST_CREATING] = $request;
            header("Location: ../../Views/Recaladas/create.php");
        } catch (InvalidArgumentException $e) {
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGES] = $errorMessages;
            $_SESSION[ItemsInSessionEnum::RECALADA_REQUEST_CREATING] = $request;
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
            header("Location: ../../Views/Recaladas/create.php");
        } catch (InvalidRecaladaException $e) {
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGES] = $errorMessages;
            $_SESSION[ItemsInSessionEnum::RECALADA_REQUEST_CREATING] = $request;
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
            header("Location: ../../Views/Recaladas/create.php");
        } catch (DuplicateEntryException $e) {
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGES] = $errorMessages;
            $_SESSION[ItemsInSessionEnum::RECALADA_REQUEST_CREATING] = $request;
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
            header("Location: ../../Views/Recaladas/create.php");
        } catch (InvalidPermissionException $e) {
            $this->showLogin("Acceso denegado");
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $errorMessage;
            $this->showFormCreateRecalada();
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

