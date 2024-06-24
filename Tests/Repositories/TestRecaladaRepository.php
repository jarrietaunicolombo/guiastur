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

            if ($Recalada != null && $Recalada->id > 0) {
                echo "Recalada creado";
            } else {
                echo "Recalada No creado";
            }
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testFindRecaladaAndShowData()
    {
        try {
            $id = 1;
            $repository = new RecaladaRepository();
            $Recalada = $repository->find($id);

            echo "TOTAL TURISTAS: " . $Recalada->total_turistas . "<BR>";
            echo "BUQUE: " . $Recalada->buque->nombre . "<BR>";

        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testUpdateRecaladaAndShowNewData()
    {
        try {
            $repository = new RecaladaRepository();
            $Recalada = $repository->find(1);
            $Recalada->fecha_zarpe = new DateTime();
            $Recalada->total_turistas = $Recalada->total_turistas / 2;
            $Recalada = $repository->update($Recalada);

            echo "NOMBRE: " . $Recalada->nombre . "<BR>";
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testDeleteRecaladaVerifyNonExistence()
    {
        $resul = false;
        try {
            $id = 4;
            $repository = new RecaladaRepository();
            $resul = $repository->delete($id);
            echo $resul ? "Recalada eliminado" : "Recalada no eliminado";
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";

        }
    }

    public static function testShowAllRecaladasAndShowMessageIfEmpty()
    {
        try {
            $repository = new RecaladaRepository();
            $RecaladaList = $repository->findAll();

            if (!isset($RecaladaList) || count($RecaladaList) == 0) {
                echo "No existen Recalada para mostrar";
                return;
            }
            self::showRecaladaData($RecaladaList, "TODAS LAS RECALADAS");
            
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
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
                echo "La Recalada es valida para " . $fecha->format("Y-m-d H:i:s");
            } else {
                echo "La Recalada no es validad para " . $fecha->format("Y-m-d H:i:s");
            }
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testFindRecaladaInThePortShouldShowList()
    {
        $repository = new RecaladaRepository();
        $recaladasIndePort = $repository->findRecaladaInThePort();
        // Mostrar: la lista [id, Buque, Arribo, Zarpe, Turistas, Pais Origen, número de Atenciones]
        self::showRecaladaData($recaladasIndePort, "RECALADAS EN EL PUERTO");
    }

    private static function showRecaladaData($recaladas, string $title)
    {

        $output = "<hr/><h3>$title</h3>
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

// TestRecaladaRepository::testSaveRecaladaAndRetrieveWithID();
// TestRecaladaRepository::testFindRecaladaAndShowData();
// TestRecaladaRepository::testUpdateRecaladaAndShowNewData();
// TestRecaladaRepository::testDeleteRecaladaVerifyNonExistence();
TestRecaladaRepository::testShowAllRecaladasAndShowMessageIfEmpty();
// TestRecaladaRepository::testValidateRecaladaShouldShowYesOrNo();
TestRecaladaRepository::testFindRecaladaInThePortShouldShowList();


