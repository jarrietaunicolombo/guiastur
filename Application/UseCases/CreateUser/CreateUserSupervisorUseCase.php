<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ICreateUserUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateUserCommand.php";
require_once __DIR__ . "/Dto/CreateUserSupervisorRequest.php";
require_once __DIR__ . "/Dto/CreateUserSupervisorResponse.php";
require_once __DIR__ . "/Dto/CreateUserResponse.php";
require_once __DIR__ . "/Dto/CreateUserResponse.php";


class CreateUserSupervisorUseCase implements ICreateUserUseCase {
    private $createUserCommand;

    public function __construct(ICreateUserCommand $createUserCommand)
    {
        $this->createUserCommand = $createUserCommand;
    }

    public function createUser(CreateUserRequest $request) : CreateUserResponse{
      return  $this->createUserCommand->handler($request);
    }
}