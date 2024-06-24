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
                self::showBuqueData( array($Buque), "Buque Creado");
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

            self::showBuqueData( array($Buque), "DATOS DEL BUQUE ID: $id");

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
            self::showBuqueData( array($Buque), "Buque Actualizado");
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
            self::showBuqueData( $BuqueeList, "TODOS LOS BUQUES");
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    private static function showBuqueData(array $buques, string $title)
    {
        // Mostrar: [Id, Codigo, Nombre, foto, Recaladas]
        $output = "<hr/><h3>$title</h3>
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
                        <td>" .count($buque->recaladas) . "</td> 
                        </tr>";
        }
        $output .= "</table>";
        echo $output;
    }
}


// 
// TestBuqueRepository::testSaveBuqueAndRetrieveWithID();
TestBuqueRepository::testFindBuqueAndShowData();
// TestBuqueRepository::testUpdateBuqueAndShowNewData();
// TestBuqueRepository::testDeleteBuqueVerifyNonExistence();
TestBuqueRepository::testShowAllBuqueesAndShowMessageIfEmpty();

