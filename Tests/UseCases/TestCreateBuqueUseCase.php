<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Actions/Commands/CreateBuqueCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateBuque/Dto/CreateBuqueRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateBuque/Dto/CreateBuqueResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateBuque/CreateBuqueUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/BuqueRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/Utility.php";


class TestCreateBuqueUseCase
{
    public static function TestCreateBuqueUseShouldShowData()
    {
        try {
            // Arrange
            $codigo = Utility::generateGUID(1);
            $nombre = "Buque Insignia de Venezuala";
            $usuario_registro = 1;
            $createBuqueRequest = new CreateBuqueRequest($codigo, $nombre, null, $usuario_registro);
            $repositorio = new BuqueRepository();
            $createBuqueAction = new CreateBuqueCommandHandler($repositorio);
            $createBuqueUseCase = new CreateBuqueUseCase($createBuqueAction);

            // Act
            $createBuqueResponse = $createBuqueUseCase->createBuque($createBuqueRequest);

            // Assert
            self::showBuqueData($createBuqueResponse, "Buque Creado");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">Error al Crear Buque <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    private static function showBuqueData(CreateBuqueResponse $response, string $title)
    {
        $output = "<hr/><h3 style='color: blue;'>$title</h3>
                        <table border=4> 
                            <tr> 
                                <th>BUQUE ID</th> 
                                <th>CODIGO</th> 
                                <th>NOMBRE</th> 
                                <th>FOTO</th> 
                                <th>RECALADAS</th> 
                          </tr> 
                          <tr>
                                <td>" . $response->getId() . "</td> 
                                <td>" . $response->getBuque()->getCodigo() . "</td> 
                                <td>" . $response->getBuque()->getNombre() . "</td> 
                                <td>" . $response->getBuque()->getFechaRegistro()->format("Y-m-d H:i:s") . "</td>  
                                <td>" . $response->getBuque()->getUsuarioRegistro() . "</td> 
                        </tr>";
        $output .= "</table>";
        echo $output;
    }

}

TestCreateBuqueUseCase::TestCreateBuqueUseShouldShowData();