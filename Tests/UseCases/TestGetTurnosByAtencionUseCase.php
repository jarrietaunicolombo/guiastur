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
            self::showTunosData($response, "TURNOS DE LA ATENCION ID: $atencionId");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">Error al Obtener Turnos Por Atencion<br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }
    private static function showTunosData(GetTurnosByAtencionResponse $response, string $title)
    {
        $turnos = $response->getTurnos();

        $output = "<hr/><h3 style='color: blue;'>$title</h3>
                    <table border=4> 
                        <tr> 
                            <th>ATENCION ID</th> 
                            <th>TOTAL TURNOS</th> 
                        </tr> 
                        <TR>
                            <td>" . $response->getAtencionId() . "</td> 
                            <td>" . $response->getTotalTurnos() . "</td> 
                        </tr>
                    </table>
                    
                <hr/><h3 style='color: blue;'>TURNOS</h3>
                    <table border=4> 
                        <tr> 
                            <th>TURNO ID</th> 
                            <th>NUMERO</th> 
                            <th>ESTADO</th> 
                            <th>GUIA CC</th> 
                            <th>USADO</th> 
                            <th>REGISTRÓ USO</th> 
                            <th>LIBERADO</th> 
                            <th>REGISTRÓ SALIDA</th> 
                            <th>TERMINADO</th> 
                            <th>REGISTRÓ REGRESO</th>  
                            <th>CREADO</th> 
                            <th>CREADO POR</th> 
                        </tr> ";
        foreach ($turnos as $turno) {
            $output .= "<tr> 
                            <td>" . $turno->getId() . "</td> 
                            <td>" . $turno->getNumero() . "</td> 
                            <td>" . $turno->getEstado() . "</td> 
                            <td>" . $turno->getGuiaId() . "</td> 
                            <td>" . (($turno->getFechaUso())?$turno->getFechaUso()->format("Y-md H:i:s") : "")."</td> 
                            <td>" . $turno->getUsuarioUso() . "</td> 
                            <td>" . (($turno->getFechaSalida())?$turno->getFechaSalida()->format("Y-md H:i:s") : "")."</td> 
                            <td>" . $turno->getUsuarioSalida() . "</td>
                            <td>" . (($turno->getFechaRegreso())?$turno->getFechaRegreso()->format("Y-md H:i:s") : "")."</td> 
                            <td>" . $turno->getUsuarioRegreso() . "</td>
                            <td>" . $turno->getObservaciones() . "</td> 
                            <td>" . (($turno->getFechaRegistro())?$turno->getFechaRegistro()->format("Y-md H:i:s") : "")."</td> 
                            <td>" . $turno->getUsuarioRegistro() . "</td>
                        </tr> ";
        }
        $output .= "</table>";
        echo $output;
    }
}
TestGetTunosByAtencionUseCase::TestGetTunosByAtencionShouldShowList();
