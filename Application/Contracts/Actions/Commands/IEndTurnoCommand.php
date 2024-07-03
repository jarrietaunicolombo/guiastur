<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/EndTurno/Dto/EndTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/EndTurno/Dto/EndTurnoResponse.php";

interface IEndTurnoCommand {
    public function handler(EndTurnoRequest $request) : EndTurnoResponse;
}