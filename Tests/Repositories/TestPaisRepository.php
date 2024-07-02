<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Pais.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/PaisRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/EntityReferenceNotFoundException.php";

class TestPaisRepository
{
    public static function testSavePaisAndRetrieveWithID()
    {
        try {
            $Pais = new Pais();
            $Pais->nombre = "Italia";
            $Pais->nombre = $Pais->nombre.".png";

            $Pais->fecha_registro = new DateTime();
            $Pais->usuario_registro = 1;
            $repository = new PaisRepository();
            $Pais = $repository->create($Pais);
            self::showPaises( array($Pais),  "PAIS CREADO ");
        } catch (EntityReferenceNotFoundException $e) {
            echo '<hr><span style="color: red">ERROR CREAR EL PAIS <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
        catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR CREAR EL PAIS <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testFindPaisAndShowData()
    {
        try {
            $id = 1;
            $repository = new PaisRepository();
            $Pais = $repository->find($id);
            self::showPaises( array($Pais),  "DATOS DEL PAIS ID:  $id ");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR BUSCAR EL PAIS <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testUpdatePaisAndShowNewData()
    {
        try {
            $repository = new PaisRepository();
            $id = 2;
            $Pais = $repository->find($id);
            $Pais->nombre = "Italy";
            $Pais = $repository->update($Pais);
            self::showPaises( array($Pais),  "PAIS ID:  $id  ACTUALIZADO ");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR ACTUALIZAR EL PAIS <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testDeletePaisVerifyNonExistence()
    {
        $resul = false;
        try {
            $id = 4;
            $repository = new PaisRepository();
            $resul = $repository->delete($id);
            echo  $resul ? '<hr><span style="color: green"> Pais ID: '.$id .'fue eliminada<br></span>' : '<hr><span style="color: red"> Pais ID: '.$id .' No fue eliminada<br></span>'; 
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR EL ELIMINAR EL PAIS <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testShowAllPaisesAndShowMessageIfEmpty()
    {
        try {
            $repository = new PaisRepository();
            $PaiseList = $repository->findAll();

            if (!isset($PaiseList) || count($PaiseList) == 0) {
                echo '<hr><span style="color: red"> No existen Paises para mostrar<br></span>';
                return;
            }
            self::showPaises( $PaiseList,  "LISTA DE TODOS LOS PAISES");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR LISTAR TODOS LOS PAISES <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    private static function showPaises(array $paises, string $title)
    {
          $output = "<hr/><h3 style='color: blue;'>$title</h3>
                        <table border=4> <tr> 
                          <th>ID</th> 
                          <th>NOMBRE</th> 
                          <th>BANDERA</th> 
                          <th>RECALADAS</th> 
                          </tr> ";
        foreach ($paises as $pais) {
            $output .= "<td>" . $pais->id . "</td> 
                        <td>" . $pais->nombre . "</td> 
                        <td>" . $pais->bandera . "</td> 
                        <td>" . count($pais->recaladas) . "</td> 
                        </tr>";
        }
        $output .= "</table>";
        echo $output;
    }
}

TestPaisRepository::testSavePaisAndRetrieveWithID();
TestPaisRepository::testFindPaisAndShowData();
TestPaisRepository::testUpdatePaisAndShowNewData();
TestPaisRepository::testDeletePaisVerifyNonExistence();
TestPaisRepository::testShowAllPaisesAndShowMessageIfEmpty();

