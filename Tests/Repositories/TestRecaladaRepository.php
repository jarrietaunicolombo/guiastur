<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Recalada.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/RecaladaRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/EntityReferenceNotFoundException.php";

class TestRecaladaRepository
{
    public static function testSaveRecaladaAndRetrieveWithID()
    {
        try {
            $buque = 1;
            $pais = 1;

            $Recalada = new Recalada();
            $Recalada->fecha_arribo = new DateTime();
            $Recalada->fecha_zarpe = new DateTime();
            $Recalada->total_turistas = 500;
            $Recalada->observaciones = "Turistas pensionados de ONU";
            $Recalada->buque_id = $buque;
            $Recalada->pais_id = $pais;
            $Recalada->fecha_registro = new DateTime();
            $Recalada->usuario_registro = 1;
            $repository = new RecaladaRepository();
            $Recalada = $repository->create($Recalada);
            self::showRecaladaData(array($Recalada), "RECALADA CREADA" );
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR BUSCAR LA RECALADA<br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testFindRecaladaAndShowData()
    {
        try {
            $id = 1;
            $repository = new RecaladaRepository();
            $Recalada = $repository->find($id);
            self::showRecaladaData(array($Recalada), "DATOS DE LA RECALADA $id" );
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR BUSCAR LA RECALADA<br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testUpdateRecaladaAndShowNewData()
    {
        try {
            $repository = new RecaladaRepository();
            $id = 1;
            $Recalada = $repository->find($id);
            $Recalada->fecha_zarpe = (new DateTime())->modify("+2 day");
            $Recalada->total_turistas = $Recalada->total_turistas * 2;
            $Recalada = $repository->update($Recalada);
            self::showRecaladaData(array($Recalada), "RECALADA ACTUALIZADA");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR ACTUALIZAR LA RECALADA<br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testDeleteRecaladaVerifyNonExistence()
    {
        $resul = false;
        try {
            $id = 4;
            $repository = new RecaladaRepository();
            $resul = $repository->delete($id);
            echo $resul ? '<hr><span style="color: green"> Recalada ID: ' . $id . ' fue eliminada<br></span>' : '<hr><span style="color: red"> Recalada ID: ' . $id . ' No fue eliminada<br></span>';
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR ELIMINAR LA RECALADA<br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testShowAllRecaladasAndShowMessageIfEmpty()
    {
        try {
            $repository = new RecaladaRepository();
            $RecaladaList = $repository->findAll();

            if (!isset($RecaladaList) || count($RecaladaList) == 0) {
                echo '<hr><span style="color: red"> No existen Recaladas para mostrar<br></span>';
                return;
            }
            self::showRecaladaData($RecaladaList, "TODAS LAS RECALADAS");

        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR LISTAR TODAS LAS RECALADAS<br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testValidateRecaladaShouldShowYesOrNo()
    {
        try {
            // Arrange
            $buqueId = 1;
            $fecha = (new DateTime())->modify("+5 day");
            $repository = new RecaladaRepository();
            // Act
            $isValidate = $repository->validateRecalada($buqueId, $fecha);
            // Assert 
            if ($isValidate) {
                echo '<hr><span style="color: green"> La Recalada es validad para ' . $fecha->format("Y-m-d H:i:s") . '<br></span>';
            } else {
                echo '<hr><span style="color: red"> La Atencion NO es validad para ' . $fecha->format("Y-m-d H:i:s") . '<br></span>';
            }
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR VALIDAR LA RECALADA <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testFindRecaladaInThePortShouldShowList()
    {
        try {
            $repository = new RecaladaRepository();
            $recaladasIndePort = $repository->findRecaladaInThePort();
            self::showRecaladaData($recaladasIndePort, "RECALADAS EN EL PUERTO");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR OBTENER RECALADAS EN EL PUERTO <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }

    }

    private static function showRecaladaData($recaladas, string $title)
    {

        $output = "<hr/><h3 style='color: blue;'>$title</h3>
                        <table border=4> <tr> 
                          <th>BUQUE ID</th> 
                          <th>NOMBRE</th> 
                          <th>RECALADA ID</th> 
                          <th>ARRIBO</th> 
                          <th>ZARPE</th> 
                          <th>TURISTAS</th> 
                          <th>ORIGEN</th> 
                          <th>ATENCIONES</th> 
                          </tr> ";
        foreach ($recaladas as $Recalada) {
            $output .= "<td>" . $Recalada->buque->id . "</td> 
                        <td>" . $Recalada->buque->nombre . "</td> 
                        <td>" . $Recalada->id . "</td> 
                        <td>" . $Recalada->fecha_arribo . "</td> 
                        <td>" . $Recalada->fecha_zarpe . "</td> 
                        <td>" . $Recalada->total_turistas . "</td> 
                        <td>" . $Recalada->pais->nombre . "</td> 
                        <td>" . count($Recalada->atencions) . "</td> </tr>";

        }
        $output .= "</table>";
        echo $output;
    }

}

TestRecaladaRepository::testSaveRecaladaAndRetrieveWithID();
TestRecaladaRepository::testFindRecaladaAndShowData();
TestRecaladaRepository::testUpdateRecaladaAndShowNewData();
TestRecaladaRepository::testDeleteRecaladaVerifyNonExistence();
TestRecaladaRepository::testShowAllRecaladasAndShowMessageIfEmpty();
TestRecaladaRepository::testValidateRecaladaShouldShowYesOrNo();
TestRecaladaRepository::testFindRecaladaInThePortShouldShowList();


