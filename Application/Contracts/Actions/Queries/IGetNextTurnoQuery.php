<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetNextTurno/Dto/GetNextTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetNextTurno/Dto/GetNextTurnoResponse.php";

interface IGetNextTurnoQuery{
    public function handler(GetNextTurnoRequest $request) : GetNextTurnoResponse;
}
