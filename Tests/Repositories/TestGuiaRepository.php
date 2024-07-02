<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Guia.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/GuiaRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/EntityReferenceNotFoundException.php";

class TestGuiaRepository
{
    public static function testSaveGuiaAndRetrieveWithID()
    {
        try {
            // Arrange
            $usuario = 3;
            $guia = new Guia();
            $guid = Utility::generateGUID(1);
            $guia->cedula = "7894561";
            $guia->rnt =  $guid;
            // $guia->rnt =  "66711822-95af";
            $guia->nombres = "FULANITO 5 - ". explode("-", $guia->rnt)[1];
            $guia->apellidos = "DE TAL";
            $guia->fecha_nacimiento = (new DateTime("1991-11-08"))->format('Y-m-d H:i:s');
            $guia->genero = "Femenino";
            $guia->usuario_id = $usuario;
            $guia->fecha_registro = new DateTime();
            $guia->usuario_registro = 1;
            $repository = new GuiaRepository();
            // Act
            $guia = $repository->create($guia);
            self::showGuias(array($guia), "Guia Creado");
        } catch (EntityReferenceNotFoundException $e) {
            echo '<hr><span style="color: red">ERROR AL CRAER EL GUIA <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
        catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL CRAER EL GUIA <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testFindGuiaAndShowData()
    {
        try {
            $id = "234567";
            $repository = new GuiaRepository();
            $guia = $repository->find($id);
            self::showGuias(array($guia), "GUIA ID: $id");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL BUSCAR EL GUIA <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testUpdateGuiaAndShowNewData()
    {
        try {
            $repository = new GuiaRepository();
            $guiaId = "234567";
            $guia = $repository->find($guiaId);
            $guia->observaciones = "Guía Actualizado";
            $repository->update($guia);
            self::showGuias(array($guia), "ACTUALIZADO GUIA ID: $guiaId" );
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL ACTUALIZAR EL GUIA <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testDeleteGuiaVerifyNonExistence()
    {
        try {
            $id = 2;
            $repository = new GuiaRepository();
            $repository->delete($id);
            echo '<hr><span style="color: green"> El Guia ID: '.$id .' fue eliminado<br></span>';
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL ELIMINAR EL GUIA <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testShowAllGuiasAndShowMessageIfEmpty()
    {
        try {
            $repository = new GuiaRepository();
            $guiaList = $repository->findAll();

            if (!isset($guiaList) || count($guiaList) == 0) {
                echo '<hr><span style="color: red"> No existen Guias para mostrar<br></span>';
                return;
            }
            self::showGuias($guiaList, "LISTADO DE TODOS LOS GUIAS" );
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR LISTAR TODOS LOS GUIAS <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    private static function showGuias(array $guias, string $title)
    {
          $output = "<hr/><h3 style='color: blue;'>$title</h3>
                        <table border=4> <tr> 
                          <th>USUARIO ID</th> 
                          <th>ROL</th> 
                          <th>CEDULA</th> 
                          <th>NOMBRES</th> 
                          <th>APELLIDOS</th> 
                          <th>GENERO</th> 
                          <th>FECHA NACIMIENTO</th> 
                          <th>FOTO</th> 
                          <th>OBSERVACIONES</th> 
                          <th>TURNOS</th> 
                          </tr> ";
        foreach ($guias as $guia) {
            $output .= "<td>" . $guia->usuario->id . "</td> 
                        <td>" . $guia->usuario->rol->nombre . "</td> 
                        <td>" . $guia->cedula . "</td> 
                        <td>" . $guia->nombres . "</td> 
                        <td>" . $guia->apellidos . "</td> 
                        <td>" . $guia->genero . "</td> 
                        <td>" . $guia->fecha_nacimiento . "</td> 
                        <td>" . $guia->foto . "</td> 
                        <td>" . $guia->observaciones . "</td> 
                        <td>" . count($guia->turnos) . "</td> 
                        </tr>";
        }
        $output .= "</table>";
        echo $output;
    }

}

TestGuiaRepository::testSaveGuiaAndRetrieveWithID();
TestGuiaRepository::testFindGuiaAndShowData();
TestGuiaRepository::testUpdateGuiaAndShowNewData();
TestGuiaRepository::testDeleteGuiaVerifyNonExistence();
TestGuiaRepository::testShowAllGuiasAndShowMessageIfEmpty();
