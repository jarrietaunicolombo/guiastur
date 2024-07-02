<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/AtencionRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetAtencionesByRecaladaQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetAtencionesByRecalada/GetAtencionesByRecaladaUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetAtencionesByRecalada/Dto/GetAtencionesByRecaladaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetAtencionesByRecalada/Dto/GetAtencionesByRecaladaResponse.php";



class TestGetAtencionesByRecaladaUseCase
{
    public static function testGetAtencionesByRecaladaShouldShowData()
    {
        try {
            $atencionRespository = new AtencionRepository();
            $getAtencionesByRecaladaQuery = new GetAtencionesByRecaladaQueryHandler($atencionRespository);
            $getAtencionesByRecaladaUseCase = new GetAtencionesByRecaladaUseCase($getAtencionesByRecaladaQuery);
            $recaladaId = 1;
            $request = new GetAtencionesByRecaladaRequest($recaladaId);
            $response = $getAtencionesByRecaladaUseCase->getAtencionesByRecalada($request);
            self::showAtencionesResponseData($response, "Atenciones de la Recalada $recaladaId");
        } catch (Exception $e) {
            echo '<span style="color: red"> '. $e->getMessage() . '<br></span>';
        }
    }


    public static function showAtencionesResponseData(GetAtencionesByRecaladaResponse $response, string $title)
    {
        if (count($response->getAtenciones()) < 1) {
            echo '<span style="color: red">No existen ' . $title . '</span>';
            return;
        }
        $buqueResponse = $response->getBuque();
        $recaladaResponse = $response->getRecalada();
        $output = "<hr/><h3>$title</h3>
        <table border=4> 
        <tr> 
            <th>BUQUE ID</th> 
                <th>BUQUE</th> 
                <th>RECALADA ID ID</th> 
                <th>PAIS</th> 
            </tr>
            <tr>
                <td>" . $buqueResponse->getId() . "</td> 
                <td>" . $buqueResponse->getNombre() . "</td> 
                <td>" . $recaladaResponse->getId() . "</td> 
                <td>" . $recaladaResponse->getPais() . "</td> 
          </tr>
          </table>
        <table border=1> 
          <tr> 
            <th>ATENCION ID</th> 
            <th>FECHA INICIO</th> 
            <th>FECHA CIERRE</th> 
            <th>TOTAL TURNOS</th> 
            <th>TURNOS CREADOS</th> 
            <th>TURNOS DISPONIBLES</th> 
            <th>SUPERVISOR ID</th> 
            <th>SUPERVISOR</th> 
            <th>OBSERVACIONES</th> 
          </tr>";
        $atencionesResponseList = $response->getAtenciones();
        foreach ($atencionesResponseList as $atencionResponse) {
            $output .= "<tr><td>" . $atencionResponse->getId() . "</td> 
            <td>" . $atencionResponse->getFechaInicio() . "</td> 
            <td>" . $atencionResponse->getFechaCierre() . "</td> 
            <td>" . $atencionResponse->getTotalTurnos() . "</td> 
            <td>" . $atencionResponse->getTotalTurnosCreados() . "</td> 
            <td>" . $atencionResponse->getTurnosDisponibles() . "</td> 
            <td>" . $atencionResponse->getSupervisorId() . "</td> 
            <td>" . $atencionResponse->getSupervisorNombre() . "</td> 
            <td>" . $atencionResponse->getObservaciones() . "</td></tr>";
        }
        $output .= "</table>";
        echo $output;

    }

}
TestGetAtencionesByRecaladaUseCase::testGetAtencionesByRecaladaShouldShowData();