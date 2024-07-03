<?php
require_once __DIR__ . "/Dto/GetTurnoByIdRequest.php";
require_once __DIR__ . "/Dto/GetTurnoByIdResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetTurnoByIdQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/IGetTurnoByIdUseCase.php";

class GetTurnoByIdUseCase implements IGetTurnoByIdUseCase {
    private $getTurnoByIdQuery;

    public function __construct(IGetTurnoByIdQuery $getTurnoByIdQuery) {
        $this->getTurnoByIdQuery = $getTurnoByIdQuery;
    }
    public function getTurnoById(GetTurnoByIdRequest $request): GetTurnoByIdResponse{
        return $this->getTurnoByIdQuery->handler($request);
    }

}
                                  
