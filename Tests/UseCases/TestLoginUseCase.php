<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/UsuarioRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/LoginQueryHandler.php";
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
            self::showUsuarioLoginResponse( $response, "Usuario Loggedo" );
        } catch (Exception $e) {
            echo '<hr><span style="color: red">Error Logger Usuario<br></span>';
            echo '<span style="color: red"> ' . $e->getMessage() . '<br></span>';
        }
    }

    private static function showUsuarioLoginResponse(LoginResponse $response, string $title)
    {

        $output = "<hr/><h3 style='color: blue;'>$title</h3>
                    <table border=4> 
                        <tr> 
                            <th>USUARIO ID</th> 
                            <th>NOMBRE</th> 
                            <th>ROL</th> 
                            <th>ESTADO</th> 
                            <th>EMAIL</th> 
                            <th>GUIA/SUPERVISOR</th> 
                        </tr> 
                        <TR>
                            <td>" . $response->getId() . "</td> 
                            <td>" . $response->getNombre() . "</td> 
                            <td>" . $response->getRol() . "</td> 
                            <td>" . $response->getEstado() . "</td> 
                            <td>" . $response->getEmail() . "</td> 
                            <td>" . $response->getGuiaOSupervisor() . "</td> 
                        </tr>
                    </table>";
        echo $output;
    }

}

TestLoginUseCase::TestLoginShouldShowUserData();
