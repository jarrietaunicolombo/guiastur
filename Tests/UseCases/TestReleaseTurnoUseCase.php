<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/ReleaseTurno/Dto/ReleaseTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/ReleaseTurno/Dto/ReleaseTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Actions/Commands/ReleaseTurnoCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Actions/Queries/GetTurnoByIdQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Actions/Queries/GetUsuarioByIdQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/ReleaseTurno/ReleaseTurnoUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/TurnoRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/UsuarioRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/invalidReleaseTurnoException.php";

class TestReleaseTurnoUseCase
{
    public static function testReleaseTurnoShouldShowData()
    {
        try {
            // Arrange
            $turnoId = 9;
            $usuarioId = 9;
            $usuarioRepository = new UsuarioRepository();
            $turnoRepository = new TurnoRepository();

            $getTurnoByIdQuer = new GetTurnoByIdQueryHandler($turnoRepository);
            $getUsuarioByIdQuery = new GetUsuarioByIdQueryHandler($usuarioRepository);
            $releaseTurnoCommand = new ReleaseTurnoCommandHandler($turnoRepository);
            $releaseTurnoUseCase = new ReleaseTurnoUseCase($getTurnoByIdQuer, $getUsuarioByIdQuery, $releaseTurnoCommand);
            $releaseTurnoRequest = new ReleaseTurnoRequest($turnoId, $usuarioId);
            // Act
            $releaseTurnoResponse = $releaseTurnoUseCase->releaseTurno($releaseTurnoRequest);
            // Assert   
            self::showReleaseTurnoResponseData($releaseTurnoResponse, "Turno Liberado");
            
        } catch (Exception $e) {
            echo '<hr><span style="color: red">Error al Liberar turno <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }

    }

    private static function showReleaseTurnoResponseData(ReleaseTurnoResponse $turno, string $title)
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

TestReleaseTurnoUseCase::testReleaseTurnoShouldShowData();