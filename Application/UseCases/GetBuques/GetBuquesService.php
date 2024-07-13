<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/IGetBuquesService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetBuquesQuery.php";
require_once __DIR__."/Dto/GetBuquesResponse.php";


class GetBuquesService implements IGetBuquesService {
    private $getBuquesQuery;

    public function __construct(IGetBuquesQuery $getBuquesQuery) {
        $this->getBuquesQuery = $getBuquesQuery;
    }
    
    public function getBuques() : GetBuquesResponse{
        return $this->getBuquesQuery->handler();
    }

}