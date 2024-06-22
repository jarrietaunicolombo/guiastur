<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Recalada.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IRecaladaRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateRecaladaCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ICreateRecaladaUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateRecalada/CreateRecaladaCommnadHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateRecalada/Dto/CreateRecaladaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateRecalada/Dto/CreateRecaladaResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateRecalada/CreateRecaladaUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/RecaladaRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/EntityReferenceNotFoundException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";


class TestCreateRecaladaUseCase
{
    public static function TestCreateRecaladaUseShouldShowData()
    {
        try {
            // Arrange
            $fecha_arribo = new DateTime();
            $fecha_zarpe = (new DateTime())->modify("+5 days");
            $total_turistas = 450;
            $buque_id = 1;
            $pais_id = 1;
            $observaciones = "Turistas en su mayoria con idioma Portuguez";
            $usuario_registro = 1;
            $createRecaladaRequest = new CreateRecaladaRequest(
                $fecha_arribo
                , $fecha_zarpe
                , $total_turistas
                , $observaciones
                , $buque_id
                , $pais_id
                , $usuario_registro
            );
            $repositorio = new RecaladaRepository();
            $createRecaladaAction = new CreateRecaladaCommandHandler($repositorio);
            $createRecaladaUseCase = new CreateRecaladaUseCase($createRecaladaAction);

            // Act
            $createRecaladaResponse = $createRecaladaUseCase->createRecalada($createRecaladaRequest);

            // Assert
            echo "RECALADA ID: " . $createRecaladaResponse->getId() . "<br/>";
            echo "FECHA ARRIBO: " . $createRecaladaResponse->getRecalada()->getFechaArribo()->format("Y-m-d H:i:s") . "<br/>";
            echo "FECHA ZARPE: " . $createRecaladaResponse->getRecalada()->getFechaZarpe()->format("Y-m-d H:i:s") . "<br/>";
            echo "TOTAL TURISTAS: " . $createRecaladaResponse->getRecalada()->getTotalTuristas() . "<br/>";
            echo "BUQUE ID: " . $createRecaladaResponse->getRecalada()->getBuqueId() . "<br/>";
            echo "PAIS ID: " . $createRecaladaResponse->getRecalada()->getPaisId() . "<br/>";
        } catch (Exception $e) {
            echo "" . $e->getMessage();
        }
    }

}

TestCreateRecaladaUseCase::TestCreateRecaladaUseShouldShowData();