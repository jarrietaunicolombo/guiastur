<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Actions/Commands/CreateRecaladaCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateRecalada/Dto/CreateRecaladaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateRecalada/Dto/CreateRecaladaResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateRecalada/CreateRecaladaUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/RecaladaRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/EntityReferenceNotFoundException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Actions/Queries/ValidateRecaladaQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/invalidRecaladaException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/Utility.php";


class TestCreateRecaladaUseCase
{
    public static function TestCreateRecaladaUseShouldShowData()
    {
        try {
            // Arrange
            $fecha_arribo =(new DateTime())->modify("-2 days");
            $fecha_zarpe = (new DateTime())->modify("+3 days");
            $total_turistas = 580;
            $buque_id = 5;
            $pais_id = 1;
            $observaciones = "Turistas en su mayoria con idioma Venezuela";
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
            $validateRecaladaQuery = new ValidateRecaladaQueryHandler($repositorio);
            $createRecaladaCommand = new CreateRecaladaCommandHandler($repositorio);
            $createRecaladaUseCase = new CreateRecaladaUseCase($validateRecaladaQuery, $createRecaladaCommand);
            // Act
            $createRecaladaResponse = $createRecaladaUseCase->createRecalada($createRecaladaRequest);
            // Assert
            self::showRecaladaData($createRecaladaResponse, "Recalada Creada");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">Error al Crear Recalada <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    private static function showRecaladaData(CreateRecaladaResponse $response, string $title)
    {
        $Recalada = $response->getRecalada();

        $output = "<hr/><h3 style='color: blue;'>$title</h3>
                        <table border=4> 
                        <tr> 
                            <th>RECALADA ID</th> 
                            <th>FECHA ARRIBO ID</th> 
                            <th>FECHA DE ZARPE</th> 
                            <th>OTAL TURISTAS</th> 
                            <th>BUQUE ID</th> 
                            <th>PAIS ID</th> 
                        </tr>
                        <tr>
                            <td>" . $response->getId() . "</td> 
                            <td>" . $Recalada->getFechaArribo()->format("Y-m-d H:i:s") . "</td> 
                            <td>" . $Recalada->getFechaZarpe()->format("Y-m-d H:i:s")  . "</td> 
                            <td>" . $Recalada->getTotalTuristas() . "</td> 
                            <td>" . $Recalada->getBuqueId() . "</td> 
                            <td>" . $Recalada->getPaisId() . "</td> 
                        </tr>";
        $output .= "</table>";
        echo $output;
    }
}

TestCreateRecaladaUseCase::TestCreateRecaladaUseShouldShowData();