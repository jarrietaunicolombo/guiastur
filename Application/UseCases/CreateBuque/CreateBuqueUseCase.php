<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/UseCases/ICreateBuqueUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Commands/ICreateBuqueCommand.php";
require_once __DIR__ . "/Dto/CreateBuqueRequest.php";
require_once __DIR__ . "/Dto/CreateBuqueResponse.php";


class CreateBuqueUseCase implements ICreateBuqueUseCase {
    private $createBuqueCommand;

    public function __construct(ICreateBuqueCommand $createBuqueCommand)
    {
        $this->createBuqueCommand = $createBuqueCommand;
    }

    public function createBuque(CreateBuqueRequest $request) : CreateBuqueResponse{
      return  $this->createBuqueCommand->handler($request);
    }
}