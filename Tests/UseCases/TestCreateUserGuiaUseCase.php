<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Usuario.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Guia.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ICreateUserUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateUserCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IUsuarioRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateUserGuiaCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IGuiaRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ICreateUserGuiaUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Conmands/CreateUser/CreateUserCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Conmands/CreateUser/CreateUserGuiaCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/CreateUserUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/UsuarioRespository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/GuiaRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserGuiaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserGuiaResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/CreateUserGuiaUseCase.php";



class TestCreateUserGuiaUseCase
{
    public static function TestCreateUserGuiaUseShouldShowData(){
        // Arrange
        $email = "fulanito14@gmail.com";
        $password = "Abc123$$";
        $nombre = "Fulanito 14 De Tal";
        $rol_id = 3;
        $usuario_registro = 1;
        $cedula = "14121412";
        $rnt = "rnt-1234";
        $createUserRequest = new CreateUserRequest($email, $password, $nombre, $rol_id, $usuario_registro);
        $repositorio = new UsuarioRepository();
        $createUsuarioAction = new CreateUserCommandHandler($repositorio);
        $createUserUseCase = new CreateUserUseCase($createUsuarioAction);
       
        // Act
        $createUserResponse = $createUserUseCase->createUser($createUserRequest);

        $createUserGuiaRequest = new CreateUserGuiaRequest($cedula, $rnt, $createUserResponse);
        $guiaRepository = new GuiaRepository();
        $createUserGuiaCommand = new CreateUserGuiaCommandHandler($guiaRepository);
        $createUserGuiaUseCase = new CreateUserGuiaUseCase($createUserGuiaCommand);
        $createUserGuiaResponse = $createUserGuiaUseCase->createUserGuia($createUserGuiaRequest);

        // Assert
        echo "USUARIO ID: ".$createUserResponse->getId()."<br/>";
        echo "VALIDATION TOKEN: ".$createUserResponse->getValidationToken()."<br/>";
        echo "NOBRE: ".$createUserResponse->getUsuario()->getNombre()."<br/>";
        echo "ROL: ".$createUserResponse->getRolNombre()."<br/>";
        echo "CEDULA: ".$createUserGuiaResponse->getUsuario()->getCedula()."<br/>";
        echo "Nombre: ".$createUserGuiaResponse->getUsuario()->getNombres()."<br/>";
    }

}

TestCreateUserGuiaUseCase::TestCreateUserGuiaUseShouldShowData();