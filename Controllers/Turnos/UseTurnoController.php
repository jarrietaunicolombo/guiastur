<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/UseTurno/Dto/UseTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/UseTurno/Dto/UseTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/UseCases/IUseTurnoUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";

class UseTurnoController
{

    public function handleRequest($request)
    {

        SessionUtility::startSession();
        $accion = @$request["action"];
        if ($accion === "usarturno") {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->useTurno($request);
            } else {
                $errorResponse = ["error" => "Accion invalida"];
                echo json_encode($errorResponse);
                exit;
            }
        } else {
            $errorResponse = ["error" => "Accion invalida"];
            echo json_encode($errorResponse);
            exit;
        }
    }

    private function useTurno($request)
    {
        try {
            $loginUser = $_SESSION[ItemsInSessionEnum::USER_LOGIN] ?? null;
            if ($loginUser === null) {
                throw new InvalidPermissionException("Carece de los permisos necesarios");
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
        } catch (Exception $e) {
            $responseData = array("error" => $e->getMessage());
            echo json_encode($responseData);
            exit;
        }
    }

}
