<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetNextTurno/Dto/GetNextAllTurnosByStatusRequest.php";

interface IGetNextAllTurnosByStatusQuery{
    public function handler(GetNextAllTurnosByStatusRequest $request ) : array;
}
