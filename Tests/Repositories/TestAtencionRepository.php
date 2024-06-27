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
                self::showAtencionesData(array($Atencion), "ATENCIONES CREADA");
            } else {
                echo '<hr><span style="color: red"> La Atencion no fue creada<br></span>';
            }
        } catch (EntityReferenceNotFoundException $e) {
            echo '<span style="color: red">ERROR AL CREAR LA ATENCION <br></span>';
            echo '<span style="color: red"> '. $e->getMessage() . '<br></span>';
        } catch (Exception $e) {
             echo '<hr><span style="color: red">ERROR AL CREAR LA ATENCION <br></span>';
            echo '<span style="color: red"> '. $e->getMessage() . '<br></span>';
        }
    }

    public static function testFindAtencionAndShowData()
    {
        try {
            $id = 2;
            $repository = new AtencionRepository();
            $Atencion = $repository->find($id);

            self::showAtencionesData(array($Atencion), "ATENCION $id");

        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL BUSCAR LA ATENCION <br></span>';
            echo '<span style="color: red"> '. $e->getMessage() . '<br></span>';
        }
    }

    public static function testUpdateAtencionAndShowNewData()
    {
        try {
            $repository = new AtencionRepository();
            $Atencion = $repository->find(1);
            $Atencion->fecha_cierre = new DateTime();
            $Atencion->total_turnos = $Atencion->total_turnos / 2;
            $Atencion = $repository->update($Atencion);
            self::showAtencionesData(array($Atencion), "ATENCION ACTUALIZADA");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL ACTUALIZAR LA ATENCION <br></span>';
            echo '<span style="color: red"> '. $e->getMessage() . '<br></span>';
        }
    }

    public static function testDeleteAtencionVerifyNonExistence()
    {
        $resul = false;
        try {
            $id = 4;
            $repository = new AtencionRepository();
            $resul = $repository->delete($id);
            echo  $resul ? '<hr><span style="color: green"> La Atencion  fue eliminada<br></span>' : '<hr><span style="color: red"> La Atencion no fue eliminada<br></span>'; 
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL ELIMINAR LA ATENCION <br></span>';
            echo '<span style="color: red"> '. $e->getMessage() . '<br></span>';
        }
    }

    public static function testShowAllAtencionsAndShowMessageIfEmpty()
    {
        try {
            $repository = new AtencionRepository();
            $AtencionList = $repository->findAll();

            if (!isset($AtencionList) || count($AtencionList) == 0) {
                echo '<hr><span style="color: red"> No existen atenciones para mostrar<br></span>';
                return;
            }
            self::showAtencionesData($AtencionList, "TODAS LAS ATENCIONES");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL MOSTAR TODAS LAS ATENCIONES <br></span>';
            echo '<span style="color: red"> '. $e->getMessage() . '<br></span>';
        }
    }

    public static function testValidateAtencionShouldShowYesOrNo()
    {
        try {
            // Arrange
            $recaladaId = 1;
            $fecha = new DateTime();
            // $fecha = (new DateTime())->modify("+20 day");
            $repository = new AtencionRepository();
            // Act
            $isValidate = $repository->validateAtencion($recaladaId, $fecha);
            // Assert 
            if ($isValidate) {
                echo '<hr><span style="color: green"> La Atencion es validad para ' . $fecha->format("Y-m-d H:i:s") . '<br></span>';
            } else {
                echo '<hr><span style="color: red"> La Atencion no es validad para ' . $fecha->format("Y-m-d H:i:s") . '<br></span>';
            }
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL VALIDAR LA ATENCION <br></span>';
            echo '<span style="color: red"> '. $e->getMessage() . '<br></span>';
        }
    }

    public static function testGetAtencionesByRecaladaShouldShowData()
    {
        $recaladaId = 1;
        $title = "Atenciones de la Recalada $recaladaId";
        try {
            $atencionRepository = new AtencionRepository();
            $atenciones = $atencionRepository->findByRecalada($recaladaId);
            self::showAtencionesData($atenciones, $title );
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL OBTENER ATENCIONES POR RECALADA <br></span>';
            echo '<span style="color: red"> '. $e->getMessage() . '<br></span>';
        }
    }

    private static function showAtencionesData($atenciones, string $title)
    {
        $output = "<hr/><h3 style='color: blue;'>$title</h3>
                        <table border=4> <tr> 
                          <th>BUQUE ID</th> 
                          <th>NOMBRE</th> 
                          <th>RECALADA ID</th> 
                          <th>ATENCION ID</th> 
                          <th>INICIO</th> 
                          <th>CIERRE</th> 
                          <th>TOTAL TURNOS</th> 
                          <th>TURNOS CREADOS</th> 
                          <th>TURNOS DISPONIBLES</th> 
                          <th>SUPERVISOR</th> 
                          </tr> ";
        foreach ($atenciones as $atencion) {
            $output .= "<td>" . $atencion->recalada->buque->id . "</td> 
                        <td>" . $atencion->recalada->buque->nombre . "</td> 
                        <td>" . $atencion->recalada->id . "</td> 
                        <td>" . $atencion->id . "</td> 
                        <td>" . $atencion->fecha_inicio . "</td> 
                        <td>" . $atencion->fecha_cierre . "</td> 
                        <td>" . $atencion->total_turnos . "</td> 
                        <td>" . count($atencion->turnos) . "</td> 
                        <td>" . ($atencion->total_turnos - count($atencion->turnos)) . "</td>
                        <td>" . $atencion->supervisor_id . "</td> </tr>";

        }
        $output .= "</table>";
        echo $output;
    }
}

TestAtencionRepository::testSaveAtencionAndRetrieveWithID();
TestAtencionRepository::testFindAtencionAndShowData();
TestAtencionRepository::testUpdateAtencionAndShowNewData();
TestAtencionRepository::testDeleteAtencionVerifyNonExistence();
TestAtencionRepository::testShowAllAtencionsAndShowMessageIfEmpty();
TestAtencionRepository::testValidateAtencionShouldShowYesOrNo();
TestAtencionRepository::testGetAtencionesByRecaladaShouldShowData();
