<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ICreateRecaladaUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateRecaladaCommand.php";
require_once __DIR__ . "/Dto/CreateRecaladaRequest.php";
require_once __DIR__ . "/Dto/CreateRecaladaResponse.php";


class CreateRecaladaUseCase implements ICreateRecaladaUseCase {
    private $createRecaladaCommand;

    public function __construct(ICreateRecaladaCommand $createRecaladaCommand) {
        $this->createRecaladaCommand = $createRecaladaCommand;    
    }
    public function createRecalada(CreateRecaladaRequest $createRecaladaRequest) : CreateRecaladaResponse {
        return $this->createRecaladaCommand->handler($createRecaladaRequest);
    }

}
