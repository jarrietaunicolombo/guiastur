<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Turno.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/TurnoRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/EntityReferenceNotFoundException.php";

class TestTurnoRepository
{
    public static function testSaveTurnoAndRetrieveWithID()
    {
        try {
            // Arrange
            $guia = '7654321';
            $atencion = 1;
            $Turno = new Turno();
            $Turno->numero = 2;
            $Turno->fecha_uso = new DateTime();
            // $Turno->total_salisa = new DateTime();
            // $Turno->total_regreso = new DateTime();
            // $Turno->observaciones = "";
            $Turno->guia_id = $guia;
            $Turno->atencion_id = $atencion;
            $Turno->fecha_registro = new DateTime();
            $Turno->usuario_registro = 1;
            $repository = new TurnoRepository();
            // Act
            $Turno = $repository->create($Turno);
            // Assert
            if ($Turno != null && $Turno->id > 0) {
                echo "Turno creado";
            } else {
                echo "Turno No creado";
            }
        } catch (EntityReferenceNotFoundException $e) {
            echo "ERROR: ".$e->getMessage() ;
        }
        catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testFindTurnoAndShowData()
    {
        try {
            $id = 2;
            $repository = new TurnoRepository();
            $Turno = $repository->find($id);

            echo "ID: " . $Turno->id . "<br>";
            echo "NUMERO: " . $Turno->numero . "<br>";
            echo "USADO: " . $Turno->fecha_uso . "<br>";
            echo "SALIDA: " . $Turno->fecha_salida . "<br>";
            echo "REGRESO: " . $Turno->fecha_regreso . "<br>";
            echo "OBSERVACIONES: " . $Turno->observaciones. "<br>";
            echo "GUIA: " . $Turno->guia->nombres . "<br>";
            echo "ATENSION: " . $Turno->atencion->recalada->buque->nombre . "<br>";
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testUpdateTurnoAndShowNewData()
    {
        try {
            $id = 2;
            $guia_id = '55443322';
            $atencion = 2;
            $repository = new TurnoRepository();
            $Turno = $repository->find($id);
            $Turno->numero = 2;
            // $Turno->fecha_uso = new DateTime();
            // $Turno->total_salisa = new DateTime();
            // $Turno->total_regreso = new DateTime();
            // $Turno->observaciones = "";
            $Turno->guia_id = $guia_id;
            $Turno->atencion_id = $atencion;
            $Turno = $repository->update($Turno);

            echo "OBSERVACIONES: " . $Turno->observaciones . "<BR>";
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testDeleteTurnoVerifyNonExistence()
    {
        $resul = false;
        try {
            $id = 3;
            $repository = new TurnoRepository();
            $resul = $repository->delete($id);
            echo $resul ? "Turno eliminado" : "Turno no eliminado";
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testShowAllTurnosAndShowMessageIfEmpty()
    {
        try {
            $repository = new TurnoRepository();
            $TurnoList = $repository->findAll();

            if (!isset($TurnoList) || count($TurnoList) == 0) {
                echo "No existen Turno para mostrar";
                return;
            }
            foreach ($TurnoList as $Turno) {
                echo "ID: " . $Turno->id . "<br>";
                echo "NUMERO: " . $Turno->numero . "<br>";
                echo "USADO: " . $Turno->fecha_uso . "<br>";
                echo "SALIDA: " . $Turno->fecha_salida . "<br>";
                echo "REGRESO: " . $Turno->fecha_regreso . "<br>";
                echo "OBSERVACIONES: " . $Turno->observaciones. "<br>";
                echo "GUIA: " . $Turno->guia->nombres . "<br>";
                echo "ATENSION: " . $Turno->atencion->recalada->buque->nombre . "<br>";
            }
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testGetTunosByAtencionShouldShowList(){
        try {
            $atencionId = 2;
            $repository = new TurnoRepository();
            $turnosList = $repository->findByAtencion($atencionId);
            echo "<br>------------testGetTunosByAtencionShouldShowList------------<br>";
            foreach ($turnosList as $Turno) {
                 echo "ID: " . $Turno->id . "<br>";
                echo "NUMERO: " . $Turno->numero . "<br>";
                echo "USADO: " . ($Turno->fecha_uso!== NULL ? $Turno->fecha_uso->format("Y-m-d H:i:s") : "")."<br>";
                echo "SALIDA: " . ($Turno->fecha_salida !== NULL ? $Turno->fecha_salida->format("Y-m-d H:i:s") : ""). "<br>";
                echo "REGRESO: " . ($Turno->fecha_salida !== NULL ? $Turno->fecha_regreso->format("Y-m-d H:i:s") : "").  "<br>";
                echo "OBSERVACIONES: " . $Turno->observaciones. "<br>";
                echo "GUIA: " . $Turno->guia->nombres . "<br>";
                echo "TOTAL TURNOS: " . $Turno->atencion->total_turnos . "<br>";
                echo "_______________________________________<br/>";
            }
        }
        catch (Exception $e) {
            echo "ERROR: ". $e->getMessage() . "<br>";
        }
    }
}

// TestTurnoRepository::testSaveTurnoAndRetrieveWithID();
// TestTurnoRepository::testFindTurnoAndShowData();
// TestTurnoRepository::testUpdateTurnoAndShowNewData();
// TestTurnoRepository::testFindTurnoAndShowData();
// TestTurnoRepository::testDeleteTurnoVerifyNonExistence();
TestTurnoRepository::testShowAllTurnosAndShowMessageIfEmpty();

TestTurnoRepository::testGetTunosByAtencionShouldShowList();
