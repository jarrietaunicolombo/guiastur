<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateBuque/Dto/CreateBuqueRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateBuque/Dto/CreateBuqueResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateBuque/CreateBuqueUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/DependencyInjection.php";

class CreateBuqueController
{

    public function handleRequest($request)
    {
        SessionUtility::startSession();
        $accion = @$request["action"];
        if (!isset($accion) || $accion !== "create") {
            SessionUtility::clearAllSession();
            SessionUtility::startSession();
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = "Accion Invalida";
            header("Location: ../../Views/Users/login.php");
            exit;
        }
        $this->createBuque($request);
    }

    public function createBuque($request)
    {
        $loginUser = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;
        if ($loginUser === null) {
            throw new InvalidPermissionException();
        }
        try {

            $codigo = $request["codigo"] ?? null;
            $nombre = @$request["nombre"];
            $userId = $loginUser->getId();
            $createRequest = new CreateBuqueRequest($codigo, $nombre, null, $userId);
            $service = DependencyInjection::getCreateBuqueServce();
            $response = $service->CreateBuque($createRequest);
            $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] = "Buque creado Id: ".$response->getId();
        } catch (Exception $e) {
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $e->getMessage();
        }
        header("Location: ../../Views/Buques/create.php");
    }

}

