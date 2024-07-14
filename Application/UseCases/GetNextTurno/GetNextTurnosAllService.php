<?php
require_once __DIR__ . "/Dto/GetNextTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/IGetNextTurnosAllService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetNextTurnosAllQuery.php";

class GetNextTurnosAllService implements IGetNextTurnosAllService {
    private $getNextTurnosAllQuery;

    public function __construct(IGetNextTurnosAllQuery $getNextTurnosAllQuery) {
        $this->getNextTurnosAllQuery = $getNextTurnosAllQuery;
    }

    public function getNextTurnos() : array {
        return $this->getNextTurnosAllQuery->handler();
    }
}
