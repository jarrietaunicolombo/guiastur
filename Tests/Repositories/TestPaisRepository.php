<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Pais.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/PaisRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";

class TestPaisRepository
{
    public static function testSavePaisAndRetrieveWithID()
    {
        try {
            $Pais = new Pais();
            $Pais->nombre = "Colombia";
            $Pais->nombre = $Pais->nombre.".png";

            $Pais->fecha_registro = new DateTime();
            $Pais->usuario_registro = 1;
            $repository = new PaisRepository();
            $Pais = $repository->create($Pais);

            if ($Pais != null && $Pais->id > 0) {
                echo "Pais creado";
            } else {
                echo "Pais No creado";
            }
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testFindPaisAndShowData()
    {
        try {
            $id = 1;
            $repository = new PaisRepository();
            $Pais = $repository->find($id);

            echo $Pais->nombre."<BR>";

        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testUpdatePaisAndShowNewData()
    {
        try {
            $repository = new PaisRepository();
            $Pais = $repository->find(1);
            $Pais->nombre = "Chile";
            $Pais = $repository->update($Pais);

            echo "NOMBRE: " . $Pais->nombre . "<BR>";
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testDeletePaisVerifyNonExistence()
    {
        $resul = false;
        try {
            $id = 4;
            $repository = new PaisRepository();
            $resul = $repository->delete($id);
            echo $resul ? "Pais eliminado" : "Pais no eliminado";
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";

        }
    }

    public static function testShowAllPaisesAndShowMessageIfEmpty()
    {
        try {
            $repository = new PaisRepository();
            $PaiseList = $repository->findAll();

            if (!isset($PaiseList) || count($PaiseList) == 0) {
                echo "No existen Pais para mostrar";
                return;
            }
            foreach ($PaiseList as $Paise) {
                echo "ID: " . $Paise->id . "<br>";
                echo "NOMBRE: " . $Paise->nombre . "<br>";
            }
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }
}

// TestPaisRepository::testSavePaisAndRetrieveWithID();
TestPaisRepository::testFindPaisAndShowData();
// TestPaisRepository::testUpdatePaisAndShowNewData();
// TestPaisRepository::testDeletePaisVerifyNonExistence();
TestPaisRepository::testShowAllPaisesAndShowMessageIfEmpty();

