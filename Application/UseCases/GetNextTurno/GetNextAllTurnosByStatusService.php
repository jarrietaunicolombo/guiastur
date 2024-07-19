<?php
require_once __DIR__ . "/Dto/GetNextAllTurnosByStatusRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/IGetNextAllTurnosByStatusService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetNextAllTurnosByStatusQuery.php";

class GetNextAllTurnosByStatusService implements IGetNextAllTurnosByStatusService {
    private $getNextAllTurnosByStatusQuery;

    public function __construct(IGetNextAllTurnosByStatusQuery $getNextAllTurnosByStatusQuery) {
        $this->getNextAllTurnosByStatusQuery = $getNextAllTurnosByStatusQuery;
    }

    public function getNextAllTurnosByStatus(GetNextAllTurnosByStatusRequest $request) : array {
        return $this->getNextAllTurnosByStatusQuery->handler($request);
    }
}
