<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/UseCases/ICreateRecaladaUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Commands/ICreateRecaladaCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Queries/IValidateRecaladaQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/invalidRecaladaException.php";
require_once __DIR__ . "/Dto/CreateRecaladaRequest.php";
require_once __DIR__ . "/Dto/CreateRecaladaResponse.php";
require_once __DIR__ . "/Dto/ValidaRecaladaRequest.php";


class CreateRecaladaUseCase implements ICreateRecaladaUseCase
{
    private $createRecaladaCommand;
    private $validateRecaldaQuery;

    public function __construct(IValidateRecaladaQuery $validateRecaldaQuery, ICreateRecaladaCommand $createRecaladaCommand)
    {
        $this->validateRecaldaQuery = $validateRecaldaQuery;
        $this->createRecaladaCommand = $createRecaladaCommand;
    }
    public function createRecalada(CreateRecaladaRequest $createRecaladaRequest): CreateRecaladaResponse
    {
        $validateRecaladaRequeste = new ValidateRecaldaRequest(
            $createRecaladaRequest->getBuqueId(),
            $createRecaladaRequest->getFechaArribo()
        );
        $isValidate = $this->validateRecaldaQuery->handler($validateRecaladaRequeste);
        if (!$isValidate) {
            $message = "No es posible programar recaldadas para " 
                        .$createRecaladaRequest->getFechaArribo()->format("Y-m-d H:i-s")
                        . " del Buque Id: ".$createRecaladaRequest->getBuqueId() ."  ";
            throw new InvalidRecaladaException($message);
        }
        return $this->createRecaladaCommand->handler($createRecaladaRequest);
    }
}
