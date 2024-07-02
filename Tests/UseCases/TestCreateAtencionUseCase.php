<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateAtencionCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/ValidateAtencionQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateAtencion/Dto/CreateAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateAtencion/CreateAtencionUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/AtencionRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/EntityReferenceNotFoundException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";


class TestCreateAtencionUseCase
{
    public static function TestCreateAtencionUseShouldShowData()
    {
        try {
            // Arrange
            $fecha_inicio =(new DateTime())->modify("+10 days");
            $fecha_cierre = (new DateTime())->modify("+15 days");
            $total_turnos = 45;
            $observacioes = "Es necesario que los Guias hablen Frances";
            $supervisor_id = "44332211";
            $recalada_id = 1;
            $usurio_id = 1;
            $createAtencionRequest = new CreateAtencionRequest(
                $fecha_inicio
                , $fecha_cierre
                , $total_turnos
                , $observacioes
                , $supervisor_id
                , $recalada_id
                , $usurio_id
            );
            $repositorio = new AtencionRepository();
            $validateAtencionQuery = new ValidateAtencionQueryHandler($repositorio);
            $createAtencionAction = new CreateAtencionCommandHandler($repositorio);
            $createAtencionUseCase = new CreateAtencionUseCase($validateAtencionQuery, $createAtencionAction);

            // Act
            $createAtencionResponse = $createAtencionUseCase->createAtencion($createAtencionRequest);

            // Assert
            echo "ATENCION ID: " . $createAtencionResponse->getId() . "<br/>";
            echo "FECHA INICIO: " . $createAtencionResponse->getAtencion()->getFechaInicio()->format("Y-m-d H:i:s") . "<br/>";
            echo "FECHA CIERRE: " . $createAtencionResponse->getAtencion()->getFechaCierre()->format("Y-m-d H:i:s") . "<br/>";
            echo "TOTAL TURNOS: " . $createAtencionResponse->getAtencion()->getTotalTurnos() . "<br/>";
            echo "OBSERVACIONES: " . $createAtencionResponse->getAtencion()->getObservaciones() . "<br/>";
            echo "SUPERVISOR ID: " . $createAtencionResponse->getAtencion()->getSupervisorId() . "<br/>";
            echo "RECALADA ID: " . $createAtencionResponse->getAtencion()->getRecaladaId() . "<br/>";
            echo "USUARIO REGISTRO ID: " . $createAtencionResponse->getAtencion()->getUsuarioRegistro() . "<br/>";
            echo "FECHA REGISTRO: " . $createAtencionResponse->getAtencion()->getFechaRegistro()->format("Y-m-d H:i:s") . "<br/>";
        } catch (Exception $e) {
            echo "" . $e->getMessage();
        }
    }

}

TestCreateAtencionUseCase::TestCreateAtencionUseShouldShowData();