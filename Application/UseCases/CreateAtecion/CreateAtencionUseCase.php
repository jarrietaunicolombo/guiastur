<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ICreateAtencionUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateAtencionCommand.php";
require_once __DIR__ . "/Dto/CreateAtencionRequest.php";
require_once __DIR__ . "/Dto/CreateAtencionResponse.php";


class CreateAtencionUseCase implements ICreateAtencionUseCase {
    private $createAtencionCommand;
    public function __construct(ICreateAtencionCommand $createAtencionCommand) {
        $this->createAtencionCommand = $createAtencionCommand;
    }

    public function createAtencion(CreateAtencionRequest $createAtencionRequest) : CreateAtencionResponse{
        return $this->createAtencionCommand->handler($createAtencionRequest);
    }
}