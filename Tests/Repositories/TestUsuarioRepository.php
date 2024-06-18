<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Usuario.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/UsuarioRespository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";

use ActiveRecord\DatabaseException;

class TestUsuarioRepository
{
    public static function testSaveUserAndRetrieveWithID()
    {
        // Arrange
        $rol = 3;
        $usuarioAdmin = 2;
        try {
            $usuario = new Usuario();
            $usuario->nombre = "FULANITO SAPORVISOR"; 
            $usuario->email = "fulanitosaporvisor@gmail.com";
            $usuario->password = "xxxfulan***"; 
            $usuario->rol_id = $rol;
            $usuario->fecha_registro = date('Y-m-d H:i:s', strtotime('now'));
            $usuario->usuario_registro = $usuarioAdmin;
            $repository = new UsuarioRepository();
            // Actuate
            $usuario = $repository->create($usuario);
            // Assert
            if ($usuario != null && $usuario->id > 0) {
                echo "Usuario creado";
            } else {
                echo "Usuario No creado";
            }
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage() ;
        }
    }

    
    public static function testFindUserAndShowData()
    {
        try {
              // Arrange
            $id = 1;
            $repository = new UsuarioRepository();
            // Act
            $usuario = $repository->find(2);
            // Assert: 
            echo $usuario->nombre."<BR>";
            echo $usuario->email."<BR>";
           
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage();
        }
    }

    public static function testUpdaeUserAndShowNewData()
    {
        try {
              // Arrange
            $repository = new UsuarioRepository();
            $usuario = $repository->find(2);
            $usuario->nombre = "FULANITO SAPORVISOR"; 
            $usuario->email = "fulanitosaporvisor@gmail.com";
            $usuario->password = "xxxfulan***"; 
            //act
            $usuario = $repository->update($usuario);
            // Assert: 
            echo "NOMBRE: ". $usuario->nombre."<BR>";
            echo "EMAIL: ". $usuario->email."<BR>";
            echo "ROL: ". $usuario->rol->nombre."<BR>";
           
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage();
        }
    }

    public static function testDeleteUserVerifyNonExistence()
    {
        try {
              // Arrange
            $id = 3;
            $repository = new UsuarioRepository();
            // Act
           $resul =  $repository->delete($id);
            // Assert: 
            echo  $resul? "Usuario eliminado" : "Usuario no eliminado";
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage();
        }
    }

    public static function testShowAllUsersAndShowMessageIfEmpty()
    {
        try {
              // Arrange
              $repository = new UsuarioRepository();
              // Act
              $userList = $repository->findAll();
              // assert 
              if (!isset($userList) || count($userList) == 0) {
                echo "No existen usuarios para mostrar";
                return;
              }
              foreach ($userList as $user) {
                echo "ID: ".$user->id."<br>";
                echo "NOMBRE: ".$user->nombre."<br>";
                echo "EMAIL: ".$user->email."<br>";
                echo "ROL: ".$user->rol->nombre."<br>";
              }
        } catch (Exception $e) {
            echo "ERROR: ".$e->getMessage();
        }
    }
}
TestUsuarioRepository::testSaveUserAndRetrieveWithID();
// TestUsuarioRepository::testFindUserAndShowData();s
// TestUsuarioRepository::testUpdaeUserAndShowNewData();
// TestUsuarioRepository::testDeleteUserVerifyNonExistence();
TestUsuarioRepository::testShowAllUsersAndShowMessageIfEmpty();
