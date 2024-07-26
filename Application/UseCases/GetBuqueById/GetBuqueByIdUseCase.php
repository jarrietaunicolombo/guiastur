<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/UseCases/IGetBuqueByIdUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Queries/IGetBuqueByIdQuery.php";
require_once __DIR__."/Dto/GetBuqueByIdRequest.php";
require_once __DIR__."/Dto/GetBuqueByIdResponse.php";

class GetBuqueByIdUseCase implements IGetBuqueByIdUseCase {
    private $getBuqueByIdQuery;

    public function __construct(IGetBuqueByIdQuery $getBuqueByIdQuery) {
        $this->getBuqueByIdQuery = $getBuqueByIdQuery;
    }
    
    public function getBuqueById(GetBuqueByIdRequest $request) : GetBuqueByIdResponse{
        return $this->getBuqueByIdQuery->handler($request);
    }

}