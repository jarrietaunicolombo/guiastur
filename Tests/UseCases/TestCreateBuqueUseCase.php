<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Buque.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IBuqueRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateBuqueCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ICreateBuqueUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateBuque/CreateBuqueCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateBuque/Dto/CreateBuqueRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateBuque/Dto/CreateBuqueResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateBuque/CreateBuqueUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/BuqueRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";


class TestCreateBuqueUseCase
{
    public static function TestCreateBuqueUseShouldShowData(){
        // Arrange
        $codigo = Utility::generateGUID(1);
        $nombre = "Buque Insignia de Peru";
        $usuario_registro = 1;
        $createBuqueRequest = new CreateBuqueRequest($codigo, $nombre, null, $usuario_registro);
        $repositorio = new BuqueRepository();
        $createBuqueAction = new CreateBuqueCommandHandler($repositorio);
        $createBuqueUseCase = new CreateBuqueUseCase($createBuqueAction);
       
        // Act
        $createBuqueResponse = $createBuqueUseCase->createBuque($createBuqueRequest);

        // Assert
        echo "BUQUE ID: ".$createBuqueResponse->getId()."<br/>";
        echo "CODIGO: ".$createBuqueResponse->getBuque()->getCodigo()."<br/>";
        echo "NOBRE: ".$createBuqueResponse->getBuque()->getNombre()."<br/>";
        echo "ROL: ".$createBuqueResponse->getBuque()->getFechaRegistro()->format("Y-m-d H:i:s")."<br/>";
        echo "USuARIO REGISTRO: ".$createBuqueResponse->getBuque()->getUsuarioRegistro()."<br/>";
    }

}

TestCreateBuqueUseCase::TestCreateBuqueUseShouldShowData();