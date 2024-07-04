<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserSupervisorRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserSupervisorResponse.php";


interface ICreateUserSupervisorUseCase  {
    
   public function createUserSupervisor(CreateUserSupervisorRequest $request) : CreateUserSupervisorResponse;
    
}