<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserGuiaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserGuiaResponse.php";


interface ICreateUserGuiaUseCase  {
    
   public function CreateUserGuia(CreateUserGuiaRequest $request) : CreateUserGuiaResponse;
    
}