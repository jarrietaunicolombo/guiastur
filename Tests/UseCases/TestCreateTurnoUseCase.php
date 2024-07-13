<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Constants/TurnoStatusEnum.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateTurno/Dto/CreateTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateTurno/Dto/CreateTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetTurnosByAtencionQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateTurnoCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateTurno/CreateTurnoUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/TurnoRepository.php";


class TestCreateTurnoUseCase
{
    public static function TestCreateTurnoUseShouldShowData()
    {
        try {
            // Arrange
             $numero = 0 ;
             $estado =  TurnoStatusEnum::CREATED;
             $observaciones = null;
             $guia_id = '7654321';
             $atencion_id = 2;
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
            self::showTunosData($createTurnoResponse, "Turno Creado");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">Error al Crear Turno <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    private static function showTunosData(CreateTurnoResponse $response, string $title)
    {
        $turno = $response->getTurno();
        $output = "<hr/><h3 style='color: blue;'>$title</h3>
                    <table border=4> 
                        <tr> 
                          <th>TURNO ID</th> 
                          <th>NUMERO</th> 
                          <th>OBSERVACIONES</th> 
                          <th>GUIA CC</th> 
                          <th>ATENCION ID</th> 
                          <th>FECHA REGISTRO</th> 
                        </tr>
                        <tr>
                            <td>" . $response->getId()  . "</td> 
                            <td>" . $turno->getNumero() . "</td> 
                            <td>" . $turno->getObservaciones()  . "</td> 
                            <td>" . $turno->getGuiaId() . "</td> 
                            <td>" . $turno->getAtencionId(). "</td> 
                            <td>" . $turno->getFechaRegistro()->format("Y-m-d H:i:s") . "</td> 
                        </tr> ";
        $output .= "</table>";
        echo $output;
    }
}

TestCreateTurnoUseCase::TestCreateTurnoUseShouldShowData();
