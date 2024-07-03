<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/ReleaseTurno/Dto/ReleaseTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/ReleaseTurno/Dto/ReleaseTurnoResponse.php";

interface IReleaseTurnoCommand {
    public function handler(ReleaseTurnoRequest $request) : ReleaseTurnoResponse;
}