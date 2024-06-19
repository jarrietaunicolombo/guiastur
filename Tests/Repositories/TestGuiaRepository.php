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
            $usuario = 35;
            $guia = new Guia();
            $guid = Utility::generateGUID(1);
            $guia->cedula = "55443322";
            $guia->rnt =  $guid;
            // $guia->rnt =  "66711822-95af";
            $guia->nombres = "FULANITO-". explode("-", $guia->rnt)[1];
            $guia->apellidos = "DE TAL";
            $guia->fecha_nacimiento = (new DateTime("1991-11-08"))->format('Y-m-d H:i:s');
            $guia->genero = "Femenino";
            $guia->usuario_id = $usuario;
            $guia->fecha_registro = new DateTime();
            $guia->usuario_registro = 1;
            $repository = new GuiaRepository();
            // Act
            $guia = $repository->create($guia);
            echo "Guía creado.<br>";
        } catch (EntityReferenceNotFoundException $e) {
            echo "ERROR: ".$e->getMessage() ;
        }
        catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testFindGuiaAndShowData()
    {
        try {
            $id = "234567";
            $repository = new GuiaRepository();
            $guia = $repository->find($id);

            echo $guia->nombres. " " . $guia->apellidos."<BR>";
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testUpdateGuiaAndShowNewData()
    {
        try {
            $repository = new GuiaRepository();
            $guia = $repository->find("234567");
            $guia->observaciones = "Guía Actualizado";
            $repository->update($guia);

            echo "Guia actualizado con exito.<BR>";
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testDeleteGuiaVerifyNonExistence()
    {
        try {
            $id = 2;
            $repository = new GuiaRepository();
            $repository->delete($id);

            echo "Guía eliminado<br>";
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testShowAllGuiasAndShowMessageIfEmpty()
    {
        try {
            $repository = new GuiaRepository();
            $guiaList = $repository->findAll();

            if (!isset($guiaList) || count($guiaList) == 0) {
                echo "No existen guías para mostrar<br>";
                return;
            }
            foreach ($guiaList as $guia) {
                echo "ID: " . $guia->id . "<br>";
                echo "NOMBRE: " . $guia->nombres . "<br>";
            }
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage();
        }
    }
}

TestGuiaRepository::testSaveGuiaAndRetrieveWithID();
// TestGuiaRepository::testFindGuiaAndShowData();
// TestGuiaRepository::testUpdateGuiaAndShowNewData();
// TestGuiaRepository::testFindGuiaAndShowData();
// TestGuiaRepository::testDeleteGuiaVerifyNonExistence();
TestGuiaRepository::testShowAllGuiasAndShowMessageIfEmpty();
