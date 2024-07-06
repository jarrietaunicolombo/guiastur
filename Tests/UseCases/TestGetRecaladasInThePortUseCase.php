<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRecaladasInThePort/GetRecaladasInThePortUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetRecaladasInThePortQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/RecaladaRepository.php";



class TestGetRecaladasInThePortUseCase
{
    public static function TestGetRecaladasInThePortUseCaseShouldShowData()
    {
        try {
            // Arrange
            $repositorio = new RecaladaRepository();
            $getRecaladasInTheQuery = new GetRecaladasInThePortQueryHandler($repositorio);
            $getRecaladasInTheUseCase = new GetRecaladasInThePortUseCase($getRecaladasInTheQuery);
            // Act
            $recaladasInThePort = $getRecaladasInTheUseCase->getRecaladasInThePort();
            // Assert
            TestGetRecaladasInThePortUseCase::showRecaladasInThePor($recaladasInThePort, "RECALADAS EN EL PUERTO");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">Error al Obtener Recaladas en el Puerto<br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }

    }

    public static function showRecaladasInThePor($recaladas, string $title)
    {
        $output = "<hr/><h3>$title</h3>
        <table border=4> 
            <tr> 
                <th>BUQUE ID</th> 
                <th>BUQUE</th> 
                <th>RECALADA ID</th> 
                <th>FECHA ARRIBO</th> 
                <th>FECHA ZARPE</th> 
                <th>TURISTAS</th> 
                <th>PAIS ID</th> 
                <th>PAIS</th> 
                <th>ATENCIONES</th> 
                <th>OBSERVACIONES</th> 
            </tr> ";
        foreach ($recaladas as $Recalada) {
            $output .= 
            "<tr>
                <td>" . $Recalada->getBuqueId() . "</td> 
                <td>" . $Recalada->getBuqueNombre() . "</td> 
                <td>" . $Recalada->getRecaladaId() . "</td> 
                <td>" . $Recalada->getFechaArribo() . "</td> 
                <td>" . $Recalada->getFechaZarpe() . "</td> 
                <td>" . $Recalada->getTotalTuristas() . "</td> 
                <td>" . $Recalada->getPaisId() . "</td> 
                <td>" . $Recalada->getPaisNombre() . "</td> 
                <td>" . $Recalada->getNumeroAtenciones() . "</td> 
                <td>" . $Recalada->getObservaciones() . "</td>
            </tr>";
        }
        $output .= "</table>";
        echo $output;

    }


}

TestGetRecaladasInThePortUseCase::TestGetRecaladasInThePortUseCaseShouldShowData();