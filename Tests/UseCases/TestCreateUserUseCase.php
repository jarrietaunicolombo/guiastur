<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Usuario.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ICreateUserUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateUserCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IUsuarioRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Conmands/CreateUser/CreateUserCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/CreateUserUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/UsuarioRespository.php";



class TestCreateUserUseCase
{
    public static function TestCreateUserUseShouldShowData(){
        // Arrange
        $email = "fulanito12@gmail.com";
        $password = "Abc123$$";
        $nombre = "Fulanito 12 De Tal";
        $rol_id = 2;
        $usuario_registro = 1;
        $createUserRequest = new CreateUserRequest($email, $password, $nombre, $rol_id, $usuario_registro);
        $repositorio = new UsuarioRepository();
        $createUsuarioAction = new CreateUserCommandHandler($repositorio);
        $createUserUseCase = new CreateUserUseCase($createUsuarioAction);
       
        // Act
        $createUserResponse = $createUserUseCase->createUser($createUserRequest);
        // Assert
        echo "USUARIO ID: ".$createUserResponse->getId()."<br/>";
        echo "VALIDATION TOKEN: ".$createUserResponse->getValidationToken()."<br/>";
        echo "NOBRE: ".$createUserResponse->getUsuario()->getNombre()."<br/>";
        echo "ROL: ".$createUserResponse->getRolNombre()."<br/>";
    }

}

TestCreateUserUseCase::TestCreateUserUseShouldShowData();