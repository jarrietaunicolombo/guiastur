<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/FinishTurno/Dto/FinishTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/FinishTurno/Dto/FinishTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/IFinishTurnoUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/DependencyInjection.php";

class FinishTurnoController
{

    public function handleRequest($request)
    {

        SessionUtility::startSession();
        $accion = @$request["action"];
        if ($accion === "finalizarturno") {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->finishTurno($request);
            } else {
                $this->showLogin("Accion invalida");
            }
        } else {
            $this->showLogin("Accion invalida");
        }
    }

    private function finishTurno($request)
    {
        try {
            $loginUser = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;
            if ($loginUser === null) {
                throw new InvalidPermissionException();
            }


            $finishTurnoRequest = new FinishTurnoRequest(
                $request["turnoid"],
                $loginUser->getId(),
                $request["observaciones"]
            );

            $service = DependencyInjection::getFinishTurnoServce();

            // Act
            $response = $service->finishTurno($finishTurnoRequest);

            echo $response->toJSON();
            exit();
        } catch (InvalidPermissionException $e) {
            $this->showLogin("Acceso denegado");
        } catch (Exception $e) {
            $responseData = array("error" => $e->getMessage());
            echo json_encode($responseData);
        }
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
