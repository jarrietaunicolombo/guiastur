<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/FinishTurno/Dto/FinishTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/FinishTurno/Dto/FinishTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/FinishTurnoCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetTurnoByIdQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetUsuarioByIdQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/FinishTurno/FinishTurnoUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/TurnoRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/UsuarioRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/InvalidFinishTurnoException.php";

class TestFinishTurnoUseCase
{
    public static function testFinishTurnoShouldShowData()
    {
        try {
            // Arrange
            $turnoId = 9;
            $usuarioId = 9;
            $usuarioRepository = new UsuarioRepository();
            $turnoRepository = new TurnoRepository();

            $getTurnoByIdQuer = new GetTurnoByIdQueryHandler($turnoRepository);
            $getUsuarioByIdQuery = new GetUsuarioByIdQueryHandler($usuarioRepository);
            $endTurnoCommand = new FinishTurnoCommandHandler($turnoRepository);
            $endTurnoUseCase = new FinishTurnoUseCase($getTurnoByIdQuer, $getUsuarioByIdQuery, $endTurnoCommand);
            $endTurnoRequest = new FinishTurnoRequest($turnoId, $usuarioId);
            // Act
            $releaseTurnoResponse = $endTurnoUseCase->finishTurno($endTurnoRequest);
            // Assert   
            self::showFinishTurnoResponseData($releaseTurnoResponse, "Turno Finalizado");
            
        } catch (Exception $e) {
            echo '<hr><span style="color: red">Error al Finalizar turno <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }

    }

    private static function showFinishTurnoResponseData(FinishTurnoResponse $turno, string $title)
    {

        $output = "<hr/><h3 style='color: blue;'>$title</h3>
                        <table border=4> 
                        <tr> 
                            <th>TURNO ID</th> 
                            <th>NUMERO</th> 
                            <th>ESTADO</th> 
                            <th>GUIA CC</th> 
                            <th>NOMBRE</th> 
                            <th>USADO</th> 
                            <th>REGISTRÓ EL USO</th> 
                            <th>LIBERADO</th> 
                            <th>REGISTRÓ LA SALIDA</th> 
                            <th>TERMINADO</th> 
                            <th>REGISTRÓ EL REGRESO</th> 
                            <th>OBSERVACION</th> 
                            <th>ATENCION ID</th> 
                            <th>FECHA REGISTRO</th> 
                            <th>USUARIO REGISTRO</th> 
                        </tr> 
                        <TR>
                            <td>" . $turno->getId() . "</td> 
                            <td>" . $turno->getNumero() . "</td> 
                            <td>" . $turno->getEstado() . "</td> 
                            <td>" . $turno->getGuia()->getCedula() . "</td> 
                            <td>" . $turno->getGuia()->getNombre() . "</td> 
                            <td>" . $turno->getFechaUso() . "</td> 
                            <td>" . $turno->getUsuarioUso() . "</td> 
                            <td>" . $turno->getFechaSalida() . "</td> 
                            <td>" . $turno->getUsuarioSalida() . "</td> 
                            <td>" . $turno->getFechaRegreso() . "</td> 
                            <td>" . $turno->getUsuarioRegreso() . "</td> 
                            <td>" . $turno->getObservaciones() . "</td> 
                            <td>" . $turno->getAtencion()->getId() . "</td> 
                            <td>" . $turno->getFechaRegistro() . "</td> 
                            <td>" . $turno->getUsuarioRegistro() . "</td> 
                        </tr></table>";
        echo $output;
    }
}

TestFinishTurnoUseCase::testFinishTurnoShouldShowData();