<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/EndTurno/Dto/EndTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/EndTurno/Dto/EndTurnoResponse.php";


interface IEndTurnoUseCase {
    public function endTurno(EndTurnoRequest $request) : EndTurnoResponse;
}