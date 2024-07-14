<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/IGetRecaladasInThePortUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetRecaladasInThePortQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRecaladas/Dto/GetRecaladasResponse.php";

class GetRecaladasInThePortUseCase implements IGetRecaladasInThePortUseCase {
    private $getRecaladasInThePortQuery;

    public function __construct(IGetRecaladasInThePortQuery $getRecaladasInThePortQuery) {
        $this->getRecaladasInThePortQuery = $getRecaladasInThePortQuery;
    }
    
    public function getRecaladasInThePort( ) : GetRecaladasResponse {
        return $this->getRecaladasInThePortQuery->handler();
    }

}