<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Atencion.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/AtencionRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/EntityReferenceNotFoundException.php";

class TestAtencionRepository
{
    public static function testSaveAtencionAndRetrieveWithID()
    {
        try {
            // Arrange
            $supervisor = '11223344';
            $recalada = 1;
            $Atencion = new Atencion();
            $Atencion->fecha_inicio = new DateTime();
            $Atencion->fecha_cierre = new DateTime();
            $Atencion->total_turnos = 50;
            $Atencion->observaciones = "Primer dia";
            $Atencion->supervisor_id = $supervisor;
            $Atencion->recalada_id = $recalada;
            $Atencion->fecha_registro = new DateTime();
            $Atencion->usuario_registro = 1;
            $repository = new AtencionRepository();
            // Act
            $Atencion = $repository->create($Atencion);
            // Assert
            if ($Atencion != null && $Atencion->id > 0) {
                echo "Atencion creado";
            } else {
                echo "Atencion No creado";
            }
        } catch (EntityReferenceNotFoundException $e) {
            echo "ERROR: ".$e->getMessage() ;
        }
        catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testFindAtencionAndShowData()
    {
        try {
            $id = 2;
            $repository = new AtencionRepository();
            $Atencion = $repository->find($id);

            echo "ID: " . $Atencion->id . "<br>";
            echo "INICIO: " . $Atencion->fecha_inicio . "<br>";
            echo "CIERRE: " . $Atencion->fecha_cierre . "<br>";
            echo "CUPOS: " . $Atencion->total_turnos . "<br>";
            echo "CIERRE: " . $Atencion->observaciones . "<br>";
            echo "BUQUE: " . $Atencion->recalada->buque->nombre . "<br>";
            echo "SUPERVISOR: " . $Atencion->supervisor->nombres . "<br>";
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testUpdateAtencionAndShowNewData()
    {
        try {
            $repository = new AtencionRepository();
            $Atencion = $repository->find(1);
            $Atencion->fecha_cierre = new DateTime();
            $Atencion->total_turnos = $Atencion->total_turistas / 2;
            $Atencion = $repository->update($Atencion);

            echo "OBSERVACIONES: " . $Atencion->observaciones . "<BR>";
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testDeleteAtencionVerifyNonExistence()
    {
        $resul = false;
        try {
            $id = 4;
            $repository = new AtencionRepository();
            $resul = $repository->delete($id);
            echo $resul ? "Atencion eliminado" : "Atencion no eliminado";
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testShowAllAtencionsAndShowMessageIfEmpty()
    {
        try {
            $repository = new AtencionRepository();
            $AtencionList = $repository->findAll();

            if (!isset($AtencionList) || count($AtencionList) == 0) {
                echo "No existen Atencion para mostrar";
                return;
            }
            foreach ($AtencionList as $Atencion) {
                echo "ID: " . $Atencion->id . "<br>";
                echo "INICIO: " . $Atencion->fecha_inicio . "<br>";
                echo "CIERRE: " . $Atencion->fecha_cierre . "<br>";
                echo "CUPOS: " . $Atencion->total_turnos . "<br>";
                echo "CIERRE: " . $Atencion->observaciones . "<br>";
                echo "BUQUE: " . $Atencion->recalada->buque->nombre . "<br>";
                echo "SUPERVISOR: " . $Atencion->supervisor->nombres . "<br>";
            }
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }
}

// TestAtencionRepository::testSaveAtencionAndRetrieveWithID();
// TestAtencionRepository::testFindAtencionAndShowData();
// TestAtencionRepository::testUpdateAtencionAndShowNewData();
// TestAtencionRepository::testDeleteAtencionVerifyNonExistence();
TestAtencionRepository::testShowAllAtencionsAndShowMessageIfEmpty();
