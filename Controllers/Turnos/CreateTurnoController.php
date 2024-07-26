<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetAtenciones/Dto/GetAtencionResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetNextTurno/Dto/GetNextTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetNextTurno/Dto/GetNextTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateTurno/Dto/CreateTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateTurno/Dto/CreateTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/RolTypeEnum.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";

class CreateTurnoController
{

    public function handleRequest($request)
    {
        SessionUtility::startSession();
        $accion = @$request["action"];
        if ($accion === "create") {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->createTurno($request);
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

    private function createTurno($request)
    {
        try {
            // Arrange

            $userGuiaLogin = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;
            if ($userGuiaLogin === null) {
                throw new InvalidPermissionException("No tiene permisos para tomar Turnos");
            }
            if ($userGuiaLogin->getRol() !== RolTypeEnum::GUIA) {
                throw new InvalidPermissionException("No eres un Guia, no tienes permisos para tomar Turnos");
            }

            $atencion = $_SESSION[ItemsInSessionEnum::FOUND_ATENCION];
            
            $nextTurnoRequest = new GetNextTurnoRequest($atencion->getAtencionId());
            $nextTurnoService = DependencyInjection::getNextTurnoServce();
            $numero = 0;
            try {
                $response = $nextTurnoService->getNextTurno($nextTurnoRequest);
                $numero = $response->getNumero();
            } catch (NotFoundEntryException $e) {
                if($atencion->getTotalTurnos() == $atencion->getTurnosDisponibles()){
                    $numero = 1;
                }
                else{
                    throw $e;
                }
            }
            $estado = TurnoStatusEnum::CREATED;
            $observaciones = null;
            $guia_id = $userGuiaLogin->getGuiaOSupervisor();
            $atencion_id = $atencion->getAtencionId();
            $usuario_registro = $guia_id;

            $createTurnoRequest = new CreateTurnoRequest(
                $numero,
                $estado,
                $observaciones,
                $guia_id,
                $atencion_id,
                $usuario_registro
            );
            $createTurnoService = DependencyInjection::getCreateTurnoServce();
            // Act
            $createTurnoResponse = $createTurnoService->createTurno($createTurnoRequest);

            $_SESSION[ItemsInSessionEnum::CURRENT_PAGE] = $request["page"] ?? "menu";
            echo $createTurnoResponse->toJSON();
            exit;

        } catch (Exception $e) {
            $error = ["error" => $e->getMessage()];
            echo json_encode($error);
            exit;
        }
    }

    public function showFormCreate(array $request)
    {
        $atencion = @$request["atencion"] ?? null;
        if ($atencion == null) {

            $atencion = $_SESSION[ItemsInSessionEnum::FOUND_ATENCION];
        }
        header("Location: ../../Views/Turnos/index.php?action=listbyatencion&atencion=" . $atencion->getAtencionId());
    }

    private function showLogin(string $message)
    {
        -
            SessionUtility::clearAllSession();
        SessionUtility::startSession();
        $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $message;
        header("Location: ../../Views/Users/login.php");
        exit;
    }
}
