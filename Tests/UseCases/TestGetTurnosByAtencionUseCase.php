<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencionUseCase/Dto/GetTurnosByAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencionUseCase/Dto/GetTurnosByAtencionResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencionUseCase/GetTurnosByAtencionUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetTurnosByAtencionQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/TurnoRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/NotFoundEntryException.php";

class TestGetTunosByAtencionUseCase
{

    public static function TestGetTunosByAtencionShouldShowList()
    {
        try {
            // Arrange
            $atencionId = 1;
            $turnoRepository = new TurnoRepository();
            $getTurnosByAtencionQuery = new GetTurnosByAtencionQueryHandler($turnoRepository);
            $getTurnosByAtencionUseCase = new GetTurnosByAtencionUseCase($getTurnosByAtencionQuery);
            $getTurnosByAtencionRequest = new GetTurnosByAtencionRequest($atencionId);
            $response = $getTurnosByAtencionUseCase->getTurnosByAtencion($getTurnosByAtencionRequest);
            $turnos = $response->getTurnos();
            echo "<br>___________________TestGetTunosByAtencionShouldShowList_______________________<br>";
            foreach ($turnos as $turno) {
                echo "ID: " . $turno->getId() . "<br>";
                echo "NUMERO: " . $turno->getNumero() . "<br>";
                echo "USADO: " . ($turno->getFechaUso() !== NULL ? $turno->getFechaUso()->format("Y-m-d H:i:s") : "") . "<br>";
                echo "SALIDA: " . ($turno->getFechaSalida() !== NULL ? $turno->getFechaSalida()->format("Y-m-d H:i:s") : "") . "<br>";
                echo "REGRESO: " . ($turno->getFechaRegreso() !== NULL ? $turno->getFechaRegreso()->format("Y-m-d H:i:s") : "") . "<br>";
                echo "OBSERVACIONES: " . $turno->getObservaciones() . "<br>";
                echo "GUIA: " . $turno->getGuiaId() . "<br>";
                echo "ATENSION: " . $response->getAtencionId() . "<br>";
                echo "TOTAL TURNOS: " . $response->getTotalTurnos() . "<br>";
                echo "__________________________________________<br>";
            }
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage();

        }
    }
}
TestGetTunosByAtencionUseCase::TestGetTunosByAtencionShouldShowList();
