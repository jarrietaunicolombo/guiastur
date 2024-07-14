<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencion/Dto/GetTurnosByAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencion/Dto/GetTurnosByAtencionResponse.php";

interface IGetTurnosByAtencionQuery{
    public function handler(GetTurnosByAtencionRequest $request) : GetTurnosByAtencionResponse;
}