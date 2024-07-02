<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/UseTurno/Dto/UseTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/UseTurno/Dto/UseTurnoResponse.php";

interface IUseTurnoUseCase {
    public function useTurno(UseTurnoRequest $request) : UseTurnoResponse;
}