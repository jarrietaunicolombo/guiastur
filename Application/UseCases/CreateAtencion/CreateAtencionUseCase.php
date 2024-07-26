<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/UseCases/ICreateAtencionUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Commands/ICreateAtencionCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Queries/IValidateAtencionQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/invalidAtencionException.php";
require_once __DIR__ . "/Dto/CreateAtencionRequest.php";
require_once __DIR__ . "/Dto/CreateAtencionResponse.php";
require_once __DIR__ . "/Dto/ValidateAtencionRequest.php";


class CreateAtencionUseCase implements ICreateAtencionUseCase {
    private $validateAtencionQuery;
    private $createAtencionCommand;
    public function __construct(IValidateAtencionQuery $validateAtencionQuery, ICreateAtencionCommand $createAtencionCommand) {
        $this->validateAtencionQuery = $validateAtencionQuery;
        $this->createAtencionCommand = $createAtencionCommand;
    }

    public function createAtencion(CreateAtencionRequest $createAtencionRequest) : CreateAtencionResponse{
        $validateAtencionRequest = new ValidateAtencionRequest(
            $createAtencionRequest->getRecaladaId(),
            $createAtencionRequest->getFechaInicio(),
            $createAtencionRequest->getFechaCierre()
        );
        $this->validateAtencionQuery->handler($validateAtencionRequest);
        return $this->createAtencionCommand->handler($createAtencionRequest);
    }
}