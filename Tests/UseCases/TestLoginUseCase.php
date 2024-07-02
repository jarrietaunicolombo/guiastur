<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IUsuarioRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/UsuarioRespository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/ILoginQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/LoginQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ILoginUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/LoginUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";

class TestLoginUseCase
{

    public static function TestLoginShouldShowUserData()
    {
        //arrenge
        try {
            $respository = new UsuarioRepository();
            $loginQuery = new LoginQueryHandler($respository);
            $email = "fulanito3@gmail.com";
            $password = "Abc123$$$";
            $request = new LoginRequest($email, $password);
            $loginUseCase = new LoginUseCase($loginQuery);
            // Act
            $response = $loginUseCase->login($request);
            // Assert
            echo "Nombre: " . $response->getNombre() . "<br>";
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

TestLoginUseCase::TestLoginShouldShowUserData();
