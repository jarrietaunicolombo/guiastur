<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CancelTurno/Dto/CancelTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CancelTurno/Dto/CancelTurnoResponse.php";

interface ICancelTurnoCommand {
    public function handler(CancelTurnoRequest $request) : CancelTurnoResponse;
}