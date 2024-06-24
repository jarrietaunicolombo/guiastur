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
                self::showTunosData(array($Turno), "TURNO CREADO");
            } else {
                echo "Turno No creado";
            }
        } catch (EntityReferenceNotFoundException $e) {
            echo "ERROR: " . $e->getMessage();
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testFindTurnoAndShowData()
    {
        try {
            $id = 2;
            $repository = new TurnoRepository();
            $Turno = $repository->find($id);

            self::showTunosData(array($Turno), "DATOS DEL TURNO $id");
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
            self::showTunosData(array($Turno), "TURNO ACTUALIZADO");
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
            self::showTunosData($TurnoList, "TODOS LOS TURNOS");
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testGetTunosByAtencionShouldShowList()
    {
        try {
            $atencionId = 4;
            $repository = new TurnoRepository();
            $turnosList = $repository->findByAtencion($atencionId);
           self::showTunosData($turnosList, "TODOS LOS TURNOS DE LA ATENCION $atencionId");
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testNextTurno(){
        try {
            $atencionId = 4;
            $repository = new TurnoRepository();
            $turnosList = $repository->findByTurnosStateCreateByAtencion($atencionId);
            if(count($turnosList) == 0) {
                echo "NO EXISTEN TURNOS DISPONIBLES PARA LA ATENCION $atencionId";
                return;
            }
            $turno = $turnosList[0];
           self::showTunosData(array($turno), "PROXIMO TURNO DE LA ATENCION $atencionId");
           self::showTunosData($turnosList, "TURNOS EN COLA DE LA ATENCION $atencionId");
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    private static function showTunosData($turnos, string $title)
    {
        // 5.4. Mostrar: [GuiaNombre, BuqueId, RecaladaId, AtencionId, TurnoId, TurnoNumero, Estado, FechaUso, FechaSalida, FechaRegreso, ]
        $output = "<hr/><h3>$title</h3>
                        <table border=4> <tr> 
                          <th>TURNO ID</th> 
                          <th>NUMERO</th> 
                          <th>ESTADO</th> 
                          <th>GUIA CC</th> 
                          <th>NOMBRE</th> 
                          <th>USADO</th> 
                          <th>LIBERADO</th> 
                          <th>TERMINADO</th> 
                          <th>CREADO POR</th> 
                          <th>BUQUE ID</th> 
                          <th>BUQUE NOMBRE</th> 
                          <th>RECALADA ID</th> 
                          <th>ATENCION ID</th> 
                          <th>SUPERVISOR</th> 
                          <th>SUPERVISOR NOMBRE</th> 
                          </tr> ";
        foreach ($turnos as $turno) {
            $output .= "<td>" . $turno->id . "</td> 
                        <td>" . $turno->numero . "</td> 
                        <td>" . $turno->estado . "</td> 
                        <td>" . $turno->guia_id . "</td> 
                        <td>" . $turno->guia->nombres . " " . $turno->guia->apellidos . "</td> 
                        <td>" . $turno->fecha_uso . "</td> 
                        <td>" . $turno->fecha_salida . "</td> 
                        <td>" . $turno->fecha_regreso . "</td> 
                        <td>" . $turno->usuario_registro . "</td> 
                        <td>" . $turno->atencion->recalada->buque->id . "</td> 
                        <td>" . $turno->atencion->recalada->buque->nombre . "</td> 
                        <td>" . $turno->atencion->recalada->id . "</td> 
                        <td>" . $turno->atencion->id . "</td> 
                        <td>" . $turno->atencion->supervisor->cedula . "</td> 
                        <td>" . $turno->atencion->supervisor->nombres . " " . $turno->atencion->supervisor->apellidos . "</td> 
                        </tr> ";
        }
        $output .= "</table>";
        echo $output;
    }
}

// TestTurnoRepository::testSaveTurnoAndRetrieveWithID();
// TestTurnoRepository::testFindTurnoAndShowData();
// TestTurnoRepository::testUpdateTurnoAndShowNewData();
// TestTurnoRepository::testFindTurnoAndShowData();
// TestTurnoRepository::testDeleteTurnoVerifyNonExistence();
TestTurnoRepository::testShowAllTurnosAndShowMessageIfEmpty();
TestTurnoRepository::testGetTunosByAtencionShouldShowList();
TestTurnoRepository::testNextTurno();
