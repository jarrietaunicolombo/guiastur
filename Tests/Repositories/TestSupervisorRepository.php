<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Supervisor.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/SupervisorRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/EntityReferenceNotFoundException.php";

class TestSupervisorRepository
{
    public static function testSaveSupervisorAndRetrieveWithID()
    {
        try {
            // Arrange
            $usuario = 2;
            $supervisor = new Supervisor();
            $guid = Utility::generateGUID(1);
            $supervisor->cedula = "11223344";
            $supervisor->rnt = $guid;
            // $supervisor->rnt =  "66711822-95af";
            $supervisor->nombres = "FULANITO 3 - " . explode("-", $supervisor->rnt)[1];
            $supervisor->apellidos = "DE TAL";
            $supervisor->fecha_nacimiento = (new DateTime("1990-07-11"))->format('Y-m-d H:i:s');
            $supervisor->genero = "Famenino";
            $supervisor->usuario_id = $usuario;
            $supervisor->fecha_registro = new DateTime();
            $supervisor->usuario_registro = 1;
            $repository = new SupervisorRepository();
            // Act
            $supervisor = $repository->create($supervisor);
            self::showSupervisor(array($supervisor), "CREADO EL SUPERVISOR ID: $id");
        } catch (EntityReferenceNotFoundException $e) {
            echo '<hr><span style="color: red">ERROR AL CREAR EL SUPERVISOR <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL ACTUALIZAR EL SUPERVISOR <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testFindSupervisorAndShowData()
    {
        try {
            $id = "44332211";
            $repository = new SupervisorRepository();
            $supervisor = $repository->find($id);
            self::showSupervisor(array($supervisor), "DATOS DEL SUPERVISOR ID: $id");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL ACTUALIZAR EL SUPERVISOR <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testUpdateSupervisorAndShowNewData()
    {
        try {
            $repository = new SupervisorRepository();
            $id = "44332211";
            $supervisor = $repository->find($id);
            $supervisor->observaciones = "Supervisor Actualizado";
            $repository->update($supervisor);
            self::showSupervisor(array($supervisor), "ACTUALIZADO SUPERVISOR ID: $id");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL ACTUALIZAR EL SUPERVISOR <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testDeleteSupervisorVerifyNonExistence()
    {
        try {
            $id = "44332211";
            $repository = new SupervisorRepository();
            $repository->delete($id);
            echo '<hr><span style="color: green"> El Guia ID: ' . $id . ' fue eliminado<br></span>';
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL ELIMINAR EL SUPERVISOR <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testShowAllSupervisorsAndShowMessageIfEmpty()
    {
        try {
            $repository = new SupervisorRepository();
            $supervisorList = $repository->findAll();

            if (!isset($supervisorList) || count($supervisorList) == 0) {
                echo '<hr><span style="color: red"> No existen Guias para mostrar<br></span>';
                return;
            }
            self::showSupervisor($supervisorList, "TODOS LOS SUPERVISORES");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR LISTAR TODOS LOS SUPERVISORS <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    private static function showSupervisor(array $supervisores, string $title)
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
                          <th>ATENCIONES</th> 
                          </tr> ";
        foreach ($supervisores as $supervisor) {
            $output .= "<td>" . $supervisor->usuario->id . "</td> 
                        <td>" . $supervisor->usuario->rol->nombre . "</td> 
                        <td>" . $supervisor->cedula . "</td> 
                        <td>" . $supervisor->nombres . "</td> 
                        <td>" . $supervisor->apellidos . "</td> 
                        <td>" . $supervisor->genero . "</td> 
                        <td>" . $supervisor->fecha_nacimiento . "</td> 
                        <td>" . $supervisor->foto . "</td> 
                        <td>" . $supervisor->observaciones . "</td> 
                        <td>" . count($supervisor->atencions) . "</td> 
                        </tr>";
        }
        $output .= "</table>";
        echo $output;
    }
}

TestSupervisorRepository::testSaveSupervisorAndRetrieveWithID();
TestSupervisorRepository::testFindSupervisorAndShowData();
TestSupervisorRepository::testUpdateSupervisorAndShowNewData();
TestSupervisorRepository::testDeleteSupervisorVerifyNonExistence();
TestSupervisorRepository::testShowAllSupervisorsAndShowMessageIfEmpty();
