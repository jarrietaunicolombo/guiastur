<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Actions/Commands/CreateUser/CreateUserCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/CreateUserUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/UsuarioRepository.php";



class TestCreateUserUseCase
{
    public static function TestCreateUserUseShouldShowData()
    {
        // Arrange
        try {
            $email = "fulanito22@gmail.com";
            $password = "Abc123$$";
            $nombre = "Fulanito 22 De Tal";
            $rol_id = 2;
            $usuario_registro = 1;
            $createUserRequest = new CreateUserRequest($email, $password, $nombre, $rol_id, $usuario_registro);
            $repositorio = new UsuarioRepository();
            $createUsuarioAction = new CreateUserCommandHandler($repositorio);
            $createUserUseCase = new CreateUserUseCase($createUsuarioAction);

            // Act
            $createUserResponse = $createUserUseCase->createUser($createUserRequest);
            // Assert
            self::showUsuarioResponse($createUserResponse, "Usuario Creado");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">Error al Crear Usuario <br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    private static function showUsuarioResponse(CreateUserResponse $usuarioPendingTokenResponse, string $title)
    {
        $usuarioValided = $usuarioPendingTokenResponse;  // Usuari Creado con token esperando validacion
        $usuarioCreated = $usuarioPendingTokenResponse->getUsuario();  // Datos basicos del usuario
        $output = "<hr/><h3 style='color: blue;'>$title</h3>
                        <table border=4> 
                        <tr> 
                            <th>USUARIO ID</th> 
                            <th>NOMBRE</th> 
                            <th>ROL ID</th> 
                            <th>ROL</th> 
                            <th>ESTADO</th> 
                            <th>EMAIL</th> 
                            <th>TOKEN DE VALIDACION EL USO</th> 
                            <th>FECHA DE REGISTRO</th> 
                            <th>USUARIO REGISTRO</th>
                        </tr> 
                        <TR>
                            <td>" . $usuarioValided->getId() . "</td> 
                            <td>" . $usuarioCreated->getNombre() . "</td> 
                            <td>" . $usuarioCreated->getRolId() . "</td> 
                            <td>" . $usuarioValided->getRolNombre() . "</td> 
                            <td>" . $usuarioCreated->getEstado() . "</td> 
                            <td>" . $usuarioCreated->getEmail() . "</td> 
                            <td>" . $usuarioValided->getValidationToken() . "</td>   
                            <td>" . $usuarioCreated->getFechaRegistro()->format("Y-m-d H:i:s") . "</td> 
                            <td>" . $usuarioCreated->getUsuarioRegistro() . "</td>     
                        </tr></table>";
        echo $output;
    }


}

TestCreateUserUseCase::TestCreateUserUseShouldShowData();