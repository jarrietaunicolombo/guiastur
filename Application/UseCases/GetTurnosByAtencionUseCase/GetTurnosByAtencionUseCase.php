<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencionUseCase/Dto/GetTurnosByAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencionUseCase/Dto/GetTurnosByAtencionResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetTurnosByAtencionQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetTurnosByAtencionQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/IGetTurnosByAtencionUseCase.php";

class GetTurnosByAtencionUseCase implements IGetTurnosByAtencionUseCase {
    private $getTurnosByAtencionQuery;

    public function __construct(IGetTurnosByAtencionQuery $getTurnosByAtencionQuery) {
        $this->getTurnosByAtencionQuery = $getTurnosByAtencionQuery;
    }
    public function getTurnosByAtencion(GetTurnosByAtencionRequest $request): GetTurnosByAtencionResponse{
        return $this->getTurnosByAtencionQuery->handler($request);
    }

}
                                  
