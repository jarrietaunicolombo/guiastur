<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateAtencionCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/ValidateAtencionQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateAtencion/Dto/CreateAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateAtencion/Dto/CreateAtencionResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateAtencion/CreateAtencionUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/AtencionRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/EntityReferenceNotFoundException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/Utility.php";


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
            self::showAtencionResponseData( $createAtencionResponse,"Atencion Creada");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">Error al Crear Atencion <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    private static function showAtencionResponseData(CreateAtencionResponse $atenconResponse, string $title)
    {
        $atencion = $atenconResponse->getAtencion();
        $output = "<hr/><h3>$title</h3>
        <table border=4> 
            <tr> 
                <th>BUQUE ID</th> 
                <th>FECHA INICIO</th> 
                <th>FECHA CIERRE ID ID</th> 
                <th>TOTAL TURNOS</th> 
                <th>OBSERVACIONES</th> 
                <th>SUPERVISOR ID</th> 
                <th>RECALADA ID</th> 
                <th>FECHA REGISTRO</th> 
                <th>USUARIO REGISTRO</th> 
            </tr>
            <tr>
                <td>" . $atenconResponse->getId() . "</td> 
                <td>" . $atencion->getFechaInicio()->format("Y-m-d H:i:s") . "</td> 
                <td>" . $atencion->getFechaCierre()->format("Y-m-d H:i:s") . "</td> 
                <td>" . $atencion->getTotalTurnos() . "</td> 
                <td>" . $atencion->getObservaciones() . "</td> 
                <td>" . $atencion->getSupervisorId() . "</td> 
                <td>" . $atencion->getRecaladaId() . "</td> 
                <td>" . $atencion->getFechaRegistro()->format("Y-m-d H:i:s") . "</td> 
                <td>" . $atencion->getUsuarioRegistro() . "</td> 
            </tr>
          </table>";
        
        echo $output;
    }
    
}

TestCreateAtencionUseCase::TestCreateAtencionUseShouldShowData();