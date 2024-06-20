<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Buque.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/BuqueRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/EntityReferenceNotFoundException.php";

class TestBuqueRepository
{
    public static function testSaveBuqueAndRetrieveWithID()
    {
        try {
            $Buque = new Buque();
            $Buque->codigo =  Utility::generateGUID(1);
            $Buque->nombre = "Buque ". $Buque->codigo;

            $Buque->fecha_registro = new DateTime();
            $Buque->usuario_registro = 1;
            $repository = new BuqueRepository();
            $Buque = $repository->create($Buque);

            if ($Buque != null && $Buque->id > 0) {
                echo "Buque creado";
            } else {
                echo "Buque No creado";
            }
        } catch (EntityReferenceNotFoundException $e) {
            echo "ERROR: ".$e->getMessage() ;
        }
        catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testFindBuqueAndShowData()
    {
        try {
            $id = 1;
            $repository = new BuqueRepository();
            $Buque = $repository->find($id);

            echo $Buque->nombre."<BR>";

        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testUpdateBuqueAndShowNewData()
    {
        try {
            $repository = new BuqueRepository();
            $Buque = $repository->find(1);
            $Buque->nombre = "Paradise";
            $Buque = $repository->update($Buque);

            echo "NOMBRE: " . $Buque->nombre . "<BR>";
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testDeleteBuqueVerifyNonExistence()
    {
        $resul = false;
        try {
            $id = 4;
            $repository = new BuqueRepository();
            $resul = $repository->delete($id);
            echo $resul ? "Buque eliminado" : "Buque no eliminado";
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";

        }
    }

    public static function testShowAllBuqueesAndShowMessageIfEmpty()
    {
        try {
            $repository = new BuqueRepository();
            $BuqueeList = $repository->findAll();

            if (!isset($BuqueeList) || count($BuqueeList) == 0) {
                echo "No existen Buques para mostrar";
                return;
            }
            foreach ($BuqueeList as $Buquee) {
                echo "ID: " . $Buquee->id . "<br>";
                echo "NOMBRE: " . $Buquee->nombre . "<br>";
            }
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }
}
// 
// TestBuqueRepository::testSaveBuqueAndRetrieveWithID();
// TestBuqueRepository::testFindBuqueAndShowData();
// TestBuqueRepository::testUpdateBuqueAndShowNewData();
// TestBuqueRepository::testDeleteBuqueVerifyNonExistence();
TestBuqueRepository::testShowAllBuqueesAndShowMessageIfEmpty();

