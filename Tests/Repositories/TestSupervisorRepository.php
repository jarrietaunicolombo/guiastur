<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Supervisor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/SupervisorRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";

class TestSupervisorRepository
{
    public static function testSaveSupervisorAndRetrieveWithID()
    {
        try {
            // Arrange
            $supervisor = new Supervisor();
            $guid = Utility::generateGUID(1);
            $supervisor->cedula = "11223344";
            $supervisor->rnt =  $guid;
            // $supervisor->rnt =  "66711822-95af";
            $supervisor->nombres = "FULANITO-". explode("-", $supervisor->rnt)[1];
            $supervisor->apellidos = "DE TAL";
            $supervisor->fecha_nacimiento = (new DateTime("1985-05-11"))->format('Y-m-d H:i:s');

            $supervisor->genero = "Femenino";
            $supervisor->usuario_id = 5;
            $supervisor->fecha_registro = new DateTime();
            $supervisor->usuario_registro = 1;
            $repository = new SupervisorRepository();
            // Act
            $repository->create($supervisor);
            echo "Supervisor creado.<br>";
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testFindSupervisorAndShowData()
    {
        try {
            $id = "11223344";
            $repository = new SupervisorRepository();
            $guia = $repository->find($id);

            echo $guia->nombres. " " . $guia->apellidos."<BR>";
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testUpdateSupervisorAndShowNewData()
    {
        try {
            $repository = new SupervisorRepository();
            $supervisor = $repository->find("11223344");
            $supervisor->observaciones = "Supervisor Actualizado";
            $repository->update($supervisor);

            echo "Supervisor actualizado con exito.<BR>";
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testDeleteSupervisorVerifyNonExistence()
    {
        try {
            $id = "11223344";
            $repository = new SupervisorRepository();
            $repository->delete($id);
            echo "Supervisor elimimado";
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testShowAllSupervisorsAndShowMessageIfEmpty()
    {
        try {
            $repository = new SupervisorRepository();
            $supervisorList = $repository->findAll();

            if (!isset($supervisorList) || count($supervisorList) == 0) {
                echo "No existen supervisores para mostrar";
                return;
            }
            foreach ($supervisorList as $supervisor) {
                echo "ID: " .  $supervisor->cedula. "<BR>";
                echo "NOMBRE: ". $supervisor->nombres. " " . $supervisor->apellidos."<BR>";
            }
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage();
        }
    }
}

// TestSupervisorRepository::testSaveSupervisorAndRetrieveWithID();
TestSupervisorRepository::testFindSupervisorAndShowData();
// TestSupervisorRepository::testUpdateGuiaAndShowNewData();
TestSupervisorRepository::testShowAllSupervisorsAndShowMessageIfEmpty();
