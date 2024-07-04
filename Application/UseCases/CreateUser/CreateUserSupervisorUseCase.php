<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ICreateUserSupervisorUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateUserSupervisorCommand.php";
require_once __DIR__ . "/Dto/CreateUserSupervisorRequest.php";
require_once __DIR__ . "/Dto/CreateUserSupervisorResponse.php";


class CreateUserSupervisorUseCase implements ICreateUserSupervisorUseCase {
    private $createUserSupervisorCommand;

    public function __construct(ICreateUserSupervisorCommand $createUserSupervisorCommand)
    {
        $this->createUserSupervisorCommand = $createUserSupervisorCommand;
    }

    public function createUserSupervisor(CreateUserSupervisorRequest $request) : CreateUserSupervisorResponse{
      return  $this->createUserSupervisorCommand->handler($request);
    }
}