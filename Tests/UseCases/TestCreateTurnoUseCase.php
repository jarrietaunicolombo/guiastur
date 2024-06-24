<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateTurno/Dto/CreateTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateTurno/Dto/CreateTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencionUseCase/Dto/GetTurnosByAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencionUseCase/Dto/GetTurnosByAtencionResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetTurnosByAtencionQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateTurnoCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateTurno/CreateTurnoUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/TurnoRepository.php";


class TestCreateTurnoUseCase
{
    public static function TestCreateTurnoUseShouldShowData()
    {
        try {
            // Arrange
             $numero = 0 ;
             $estado = "Creado";
             $observaciones = NULL;
             $guia_id = '1234567';
             $atencion_id = 1;
             $usuario_registro = $guia_id;
        
            $createTurnoRequest = new CreateTurnoRequest(
                $numero
                , $estado
                , $observaciones
                , $guia_id
                , $atencion_id
                , $usuario_registro
            );
            $repositorio = new TurnoRepository();
            $getTurnoByAtencion = new GetTurnosByAtencionQueryHandler($repositorio);
            $createTurnoCommand = new CreateTurnoCommandHandler($repositorio);
            $createTurnoUseCase = new CreateTurnoUseCase($getTurnoByAtencion, $createTurnoCommand);

            // Act
            $createTurnoResponse = $createTurnoUseCase->createTurno($createTurnoRequest);

            // Assert
            echo "TURNO ID: " . $createTurnoResponse->getId() . "<br/>";
            echo "NUMERO: " . $createTurnoResponse->getTurno()->getNumero(). "<br/>";
            echo "OBSERVACIONES: " . $createTurnoResponse->getTurno()->getObservaciones() . "<br/>";
            echo "GUIA ID: " . $createTurnoResponse->getTurno()->getGuiaId() . "<br/>";
            echo "ATENCION ID: " . $createTurnoResponse->getTurno()->getAtencionId() . "<br/>";
            echo "FECHA REGISTRO: " . $createTurnoResponse->getTurno()->getFechaRegistro()->format("Y-m-d H:i:s") . "<br/>";
        } catch (Exception $e) {
            echo "" . $e->getMessage();
        }
    }

}

TestCreateTurnoUseCase::TestCreateTurnoUseShouldShowData();
