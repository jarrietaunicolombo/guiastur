<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Buque.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/BuqueRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/EntityReferenceNotFoundException.php";

class TestBuqueRepository
{
    public static function testSaveBuqueAndRetrieveWithID()
    {
        try {
            $Buque = new Buque();
            $Buque->codigo = Utility::generateGUID(1);
            $Buque->nombre = "Buque " . $Buque->codigo;

            $Buque->fecha_registro = new DateTime();
            $Buque->usuario_registro = 1;
            $repository = new BuqueRepository();
            $Buque = $repository->create($Buque);

            if ($Buque != null && $Buque->id > 0) {
                self::showBuqueData(array($Buque), "Buque Creado");
            } else {
                echo "Buque No creado";
            }
        } catch (EntityReferenceNotFoundException $e) {
            echo '<hr><span style="color: red">ERROR AL CRAER EL BUQUE <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        } catch (Exception $e) {
            echo "ERROR: " . $e->getMessage() . "<br>";
        }
    }

    public static function testFindBuqueAndShowData()
    {
        try {
            $id = 1;
            $repository = new BuqueRepository();
            $Buque = $repository->findById($id);

            self::showBuqueData(array($Buque), "DATOS DEL BUQUE ID: $id");

        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL BUSCAR EL BUQUE <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testUpdateBuqueAndShowNewData()
    {
        try {
            $repository = new BuqueRepository();
            $Buque = $repository->findById(1);
            $Buque->nombre = "Paradise";
            $Buque = $repository->update($Buque);
            self::showBuqueData(array($Buque), "Buque Actualizado");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL ACTUALIZAR EL BUQUE <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testDeleteBuqueVerifyNonExistence()
    {
        $resul = false;
        try {
            $id = 4;
            $repository = new BuqueRepository();
            $resul = $repository->delete($id);
            echo  $resul ? '<hr><span style="color: green"> Buque ID: '.$id .' eliminado  fue eliminada<br></span>' : '<hr><span style="color: red"> Buque ID: '.$id .' No eliminada<br></span>'; 
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL ELIMINAR EL BUQUE <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';

        }
    }

    public static function testShowAllBuqueesAndShowMessageIfEmpty()
    {
        try {
            $repository = new BuqueRepository();
            $BuqueeList = $repository->findAll();

            if (!isset($BuqueeList) || @count($BuqueeList) == 0) {
                echo '<hr><span style="color: red"> NO EXISTEN BUQUES PARA MOSTRAR <br></span>';
                return;
            }
            self::showBuqueData($BuqueeList, "TODOS LOS BUQUES");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL LISTAR TODOS LOS BUQUES <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    private static function showBuqueData(array $buques, string $title)
    {
          $output = "<hr/><h3 style='color: blue;'>$title</h3>
                        <table border=4> <tr> 
                          <th>BUQUE ID</th> 
                          <th>CODIGO</th> 
                          <th>NOMBRE</th> 
                          <th>FOTO</th> 
                          <th>RECALADAS</th> 
                          </tr> ";
        foreach ($buques as $buque) {
            $output .= "<td>" . $buque->id . "</td> 
                        <td>" . $buque->codigo . "</td> 
                        <td>" . $buque->nombre . "</td> 
                        <td>" . $buque->foto . "</td> 
                        <td>" . @count($buque->recaladas) . "</td> 
                        </tr>";
        }
        $output .= "</table>";
        echo $output;
    }
}


// 
TestBuqueRepository::testSaveBuqueAndRetrieveWithID();
TestBuqueRepository::testFindBuqueAndShowData();
TestBuqueRepository::testUpdateBuqueAndShowNewData();
TestBuqueRepository::testDeleteBuqueVerifyNonExistence();
TestBuqueRepository::testShowAllBuqueesAndShowMessageIfEmpty();

