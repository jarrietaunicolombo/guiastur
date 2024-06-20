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
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testFindRecaladaAndShowData()
    {
        try {
            $id = 1;
            $repository = new RecaladaRepository();
            $Recalada = $repository->find($id);

            echo "TOTAL TURISTAS: ".$Recalada->total_turistas."<BR>";
            echo "BUQUE: ".$Recalada->buque->nombre."<BR>";

        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
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
            echo "ERROR: ".$e->getMessage(). "<br>";
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
            echo "ERROR: ".$e->getMessage(). "<br>";

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
            foreach ($RecaladaList as $Recalada) {
                echo "ID: " . $Recalada->id . "<br>";
                echo "NUMERO DE TURISTAS: " . $Recalada->total_turistas . "<br>";
                echo "OBSERVACIONES: " . $Recalada->observaciones . "<br>";
                echo "PAIS ORIGEN: " . $Recalada->pais->nombre . "<br>";
                echo "BUQUE: " . $Recalada->buque->nombre . "<br>";
            }
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }
}

// TestRecaladaRepository::testSaveRecaladaAndRetrieveWithID();
// TestRecaladaRepository::testFindRecaladaAndShowData();
// TestRecaladaRepository::testUpdateRecaladaAndShowNewData();
// TestRecaladaRepository::testDeleteRecaladaVerifyNonExistence();
TestRecaladaRepository::testShowAllRecaladasAndShowMessageIfEmpty();

