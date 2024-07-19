<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/UseTurno/Dto/UseTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/UseTurno/Dto/UseTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/IUseTurnoUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/DependencyInjection.php";

class UseTurnoController
{

    public function handleRequest($request)
    {

        SessionUtility::startSession();
        $accion = @$request["action"];
        if ($accion === "usarturno") {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->useTurno($request);
            }
            else{
                $this->showLogin("Accion invalida");
            }
        } else {
            $this->showLogin("Accion invalida");
        }
    }

    private function useTurno($request)
    {
        try {
            $loginUser = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;
            if ($loginUser === null) {
                throw new InvalidPermissionException();
            }
         
            $service = DependencyInjection::getUseTurnoServce();
            $usetunroRequest = new UseTurnoRequest(
                $request["turnoid"],
                $loginUser->getId(),
                $request["atencionid"],
                $request["observaciones"]
            );
            $response = $service->useTurno($usetunroRequest);
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
