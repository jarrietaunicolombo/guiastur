<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/FinishTurno/Dto/FinishTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/FinishTurno/Dto/FinishTurnoResponse.php";

interface IFinishTurnoCommand {
    public function handler(FinishTurnoRequest $request) : FinishTurnoResponse;
}