<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/UseTurno/Dto/UseTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/UseTurno/Dto/UseTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Actions/Commands/UseTurnoCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Actions/Queries/GetNextTurnoQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Actions/Queries/GetUsuarioByIdQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/UseTurno/UseTurnoUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/TurnoRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/UsuarioRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/invalidUseTurnoException.php";

class TestUseTurnoUseCase
{
    public static function testUseTurnoShouldShowData()
    {
        try {
            // Arrange
            $turnoId = 9;
            $usuarioId = 3;
            $atencionId = 1;
            $usuarioRepository = new UsuarioRepository();
            $turnoRepository = new TurnoRepository();
            $getUsuarioByIdQuery = new GetUsuarioByIdQueryHandler($usuarioRepository);
            $nextTurnoQuery = new GetNextTurnoQueryHandler($turnoRepository);
            $useTurnoCommand = new UseTurnoCommandHandler($turnoRepository);
            $useTurnoUseCase = new UseTurnoUseCase($getUsuarioByIdQuery, $nextTurnoQuery, $useTurnoCommand);
            $useTurnoRequest = new UseTurnoRequest($turnoId, $usuarioId, $atencionId);
            // Act
            $useTurnoResponse = $useTurnoUseCase->useTurno($useTurnoRequest);
            // Assert   
            self::showUseTurnoResponseData($useTurnoResponse, "Turno Usado");
            
        } catch (Exception $e) {
            echo '<hr><span style="color: red">Error al Usar turno <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }

    }

    private static function showUseTurnoResponseData(UseTurnoResponse $turno, string $title)
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

TestUseTurnoUseCase::testUseTurnoShouldShowData();