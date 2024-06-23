<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencionUseCase/Dto/GetTurnosByAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencionUseCase/Dto/GetTurnosByAtencionResponse.php";

interface IGetTurnosByAtencionQuery{
    public function handler(GetTurnosByAtencionRequest $request) : GetTurnosByAtencionResponse;
}