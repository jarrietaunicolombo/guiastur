<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ICreateUserGuiaUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateUserGuiaCommand.php";
require_once __DIR__ . "/Dto/CreateUserGuiaRequest.php";
require_once __DIR__ . "/Dto/CreateUserGuiaResponse.php";


class CreateUserGuiaUseCase implements ICreateUserGuiaUseCase {
    private $createUserGuiaCommand;

    public function __construct(ICreateUserGuiaCommand $createUserGuiaCommand)
    {
        $this->createUserGuiaCommand = $createUserGuiaCommand;
    }

    public function createUserGuia(CreateUserGuiaRequest $request) : CreateUserGuiaResponse{
      return  $this->createUserGuiaCommand->handler($request);
    }
}