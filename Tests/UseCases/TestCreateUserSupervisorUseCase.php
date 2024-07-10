<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateUser/CreateUserCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateUser/CreateUserSupervisorCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/CreateUserUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/UsuarioRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/SupervisorRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserSupervisorRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserSupervisorResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/CreateUserSupervisorUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Constants/RolTypeEnum.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Constants/UsuarioStatus.php";



class TestCreateUserSupervisorUseCase
{
    public static function TestCreateUserSupervisorUseShouldShowData()
    {
        try {
            // Arrange
            $email = "fulanito9@gmail.com";
            $password = "Abc123$$";
            $nombre = "Fulanito 9 De Tal";
            $rol_id = 2;
            $usuario_registro = 1;
            $cedula = "232323
            ";
            $rnt = "rnt-$cedula";
            $createUserRequest = new CreateUserRequest($email, $password, $nombre, $rol_id, $usuario_registro);
            $repositorio = new UsuarioRepository();
            $createUsuarioAction = new CreateUserCommandHandler($repositorio);
            $createUserUseCase = new CreateUserUseCase($createUsuarioAction);

            // Act
            $createUserResponse = $createUserUseCase->createUser($createUserRequest);
            // ASSERT
            self::showUsuarioResponse($createUserResponse, "Usuario Creado");

            // Arange
            $createUserSupervisorRequest = new CreateUserSupervisorRequest(
                $cedula, $rnt, $createUserResponse
            
            );
            $guiaRepository = new SupervisorRepository();
            $createUserSupervisorCommand = new CreateUserSupervisorCommandHandler($guiaRepository);
            $createUserSupervisorUseCase = new CreateUserSupervisorUseCase($createUserSupervisorCommand);
            // Ac
            $createUserSupervisorResponse = $createUserSupervisorUseCase->createUserSupervisor($createUserSupervisorRequest);
            // Assert
            self::showUsuarioSupervisorResponse($createUserSupervisorResponse, "Usuario Supervisor Creado");
        } catch (Exception $e) {
            echo '<hr><span style="color: red">Error al Crear Usuario Supervisor <br></span>';
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



    private static function showUsuarioSupervisorResponse(CreateUserSupervisorResponse $response, string $title)
    {
        $supervisor = $response->getUsuario();  // CreateUserSupervisorRequest
        $output = "<hr/><h3 style='color: blue;'>$title</h3>
                        <table border=4> 
                        <tr> 
                            <th>CEDULA</th> 
                            <th>RNT</th> 
                            <th>NOMBRES</th> 
                            <th>FECHA REGISTRO</th> 
                        </tr> 
                        <TR>
                            <td>" . $supervisor->getCedula() . "</td> 
                            <td>" . $supervisor->getRnt() . "</td> 
                            <td>" . $supervisor->getNombres() . "</td> 
                            <td>" . $supervisor->getFechaRegistro()->format("Y-m-d H:i:s") . "</td>
                        </tr></table>";
        echo $output;
    }

}

TestCreateUserSupervisorUseCase::TestCreateUserSupervisorUseShouldShowData();