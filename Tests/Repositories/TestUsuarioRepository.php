<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Usuario.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/UsuarioRespository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/EntityReferenceNotFoundException.php";

class TestUsuarioRepository
{
    public static function testSaveUserAndRetrieveWithID()
    {
        // Arrange
        $rol = 3;
        $usuarioAdmin = 1;
        try {
            $usuario = new Usuario();
            $usuario->nombre = "FULANITO DE TAL 3";
            $usuario->email = "fulanito3@gmail.com";
            $usuario->password = "Abc123$$$";
            $usuario->rol_id = $rol;
            $usuario->fecha_registro = date('Y-m-d H:i:s', strtotime('now'));
            $usuario->usuario_registro = $usuarioAdmin;
            $repository = new UsuarioRepository();
            // Actuate
            $usuario = $repository->create($usuario);
            // Assert
            if ($usuario != null && $usuario->id > 0) {
                echo '<hr><span style="gree": red">Usuario Creado<br></span>';
                self::showUsuarioData(array($usuario), "DATOS DEL USUARIO CON");
            } else {
                echo '<hr><span style="color: red">ERROR GUARDAR EL USUARIO <br></span>';
            }
        } catch (EntityReferenceNotFoundException $e) {
            echo '<hr><span style="color: red">ERROR GUARDAR EL USUARIO <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR AL GUARDAR EL USUARIO <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
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
            self::showUsuarioData(array($usuario), "DATOS DEL USUARIO CON  $id");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR BUSCAR EL USUARIO <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testFindUserByEmailAndShowData()
    {
        try {
            // Arrange
            $email = "fulanito5@gmail.com";
            $repository = new UsuarioRepository();
            // Act
            $usuario = $repository->findByEmail($email);
            // Assert: 
            // Assert: 
            self::showUsuarioData(array($usuario), "DATOS DEL USUARIO CON EMAIL $email");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR BUSCAR EL USUARIO <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }


    public static function testUpdaeUserAndShowNewData()
    {
        try {
            // Arrange
            $repository = new UsuarioRepository();
            $Id = 2;
            $usuario = $repository->find($Id);
            $usuario->nombre = "FULANITO DE TAL XYZ";
            $usuario->email = "fulanitoxyz@gmail.com";
            $usuario->password = "xxxfulan***";
            //act
            $usuario = $repository->update($usuario);
            // Assert: 
            self::showUsuarioData(array($usuario), "DATOS DEL USUARIO $Id DE TODOS LOS USUARIOS");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR ACTUALIZAR EL USUARIO <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    public static function testDeleteUserVerifyNonExistence()
    {
        try {
            // Arrange
            $id = 3;
            $repository = new UsuarioRepository();
            // Act
            $resul = $repository->delete($id);
            // Assert: 
            echo $resul ? "Usuario eliminado" : "Usuario no eliminado";
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR LISTAR TODOS LOS USUARIOS <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
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
                echo '<hr><span style="color: red">NO EXISTEN USUARIOS PARA MOSTRAR<br></span>';
                return;
            }
            self::showUsuarioData($userList, "LISTADO DE TODOS LOS USUARIOS");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">ERROR LISTAR TODOS LOS USUARIOS <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';

        }
    }

    private static function showUsuarioData($usuarios, string $title)
    {
        $output = "<hr/><h3 style='color: blue;'>$title</h3>
                        <table border=4> <tr> 
                          <th>USUARIO ID</th> 
                          <th>EMAIL</th> 
                          <th>NOMBRE</th> 
                          <th>ESTADO</th> 
                          <th>TOKEN DE VALIDACION</th> 
                          <th>ROL ID</th> 
                          <th>ROL</th> 
                          </tr> ";
        foreach ($usuarios as $usuario) {
            $output .= "<td>" . $usuario->id . "</td> 
                        <td>" . $usuario->email . "</td> 
                        <td>" . $usuario->nombre . "</td> 
                        <td>" . $usuario->estado . "</td> 
                        <td>" . $usuario->validation_token . "</td> 
                        <td>" . $usuario->rol_id . "</td> 
                        <td>" . $usuario->rol->nombre . "</td> 
                        </tr> ";
        }
        $output .= "</table>";
        echo $output;
    }
}
TestUsuarioRepository::testSaveUserAndRetrieveWithID();
TestUsuarioRepository::testFindUserAndShowData();
TestUsuarioRepository::testUpdaeUserAndShowNewData();
TestUsuarioRepository::testDeleteUserVerifyNonExistence();
TestUsuarioRepository::testShowAllUsersAndShowMessageIfEmpty();
TestUsuarioRepository::testFindUserByEmailAndShowData();