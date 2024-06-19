<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IUsuarioRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/UsuarioRespository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Features/ILoginQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Features/Queries/LoginQuery/LoginQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ILoginUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/LoginUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";

class TestLoginUseCase{

    public static function TestLoginShouldShowUserData(){
        //arrenge
        $respository = new UsuarioRepository();
        $loginQuery = new LoginQueryHandler($respository);
        $email = "fulanito4@gmail.comx";
        $password = "Abc123$$$";
        $request = new LoginRequest($email, $password);
        $loginUseCase = new LoginUseCase($loginQuery);
        // Act
        $response = $loginUseCase->RequestAccess($request);
        echo "Nombre: ".$response->getNombre()."<br>";

        // Assert
    }
}

TestLoginUseCase::TestLoginShouldShowUserData();