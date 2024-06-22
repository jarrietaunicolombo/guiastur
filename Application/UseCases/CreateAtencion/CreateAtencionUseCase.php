<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ICreateAtencionUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateAtencionCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IValidateAtencionQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/ValidateAtencionException.php";
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
            $createAtencionRequest->getRecaladaId()
            , $createAtencionRequest->getFechaInicio()
        );
        $isValid = $this->validateAtencionQuery->handler($validateAtencionRequest);
        if(!$isValid) {
            $message = "No es posible programar una Atencion para " 
                        .$validateAtencionRequest->getFecha()->format("Y-m-d H:i-s")
                        . ", Existe una Atencion abierta para la Recalda: ".$validateAtencionRequest->getRecaladaId() ;
            throw new ValidateAtencionException($message);
        }
        return $this->createAtencionCommand->handler($createAtencionRequest);
    }
}