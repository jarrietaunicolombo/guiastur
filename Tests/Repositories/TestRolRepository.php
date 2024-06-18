<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Rol.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/RolRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";

class TestRolRepository
{
    public static function testSaveRolAndRetrieveWithID()
    {
        try {
            $rol = new Rol();
            $rol->nombre = "Usuario";
            $rol->fecha_registro = new DateTime();
            $rol->usuario_registro = 1;
            $rol->descripcion = "Una persona creada en el sistema pero habilitada solo para consultar cierto tipo de informacion";
            $repository = new RolRepository();
            $rol = $repository->create($rol);

            if ($rol != null && $rol->id > 0) {
                echo "Rol creado";
            } else {
                echo "Rol No creado";
            }
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testFindRolAndShowData()
    {
        try {
            $id = 1;
            $repository = new RolRepository();
            $rol = $repository->find($id);

            echo $rol->nombre."<BR>";
            echo $rol->descripcion."<BR>";

        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testUpdateRolAndShowNewData()
    {
        try {
            $repository = new RolRepository();
            $rol = $repository->find(1);
            $rol->nombre = "Super Admin";
            $rol = $repository->update($rol);

            echo "NOMBRE: " . $rol->nombre . "<BR>";
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }

    public static function testDeleteRolVerifyNonExistence()
    {
        $resul = false;
        try {
            $id = 4;
            $repository = new RolRepository();
            $resul = $repository->delete($id);
            echo $resul ? "Rol eliminado" : "Rol no eliminado";
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";

        }
    }

    public static function testShowAllRolesAndShowMessageIfEmpty()
    {
        try {
            $repository = new RolRepository();
            $roleList = $repository->findAll();

            if (!isset($roleList) || count($roleList) == 0) {
                echo "No existen roles para mostrar";
                return;
            }
            foreach ($roleList as $role) {
                echo "ID: " . $role->id . "<br>";
                echo "NOMBRE: " . $role->nombre . "<br>";
            }
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage(). "<br>";
        }
    }
}

// TestRolRepository::testSaveRolAndRetrieveWithID();
// TestRolRepository::testFindRolAndShowData();
// TestRolRepository::testUpdateRolAndShowNewData();
// TestRolRepository::testDeleteRolVerifyNonExistence();
TestRolRepository::testShowAllRolesAndShowMessageIfEmpty();

