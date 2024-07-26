<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetTurnosByAtencion/Dto/GetTurnosByAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetTurnosByAtencion/Dto/GetTurnosByAtencionResponse.php";

interface IGetTurnosByAtencionUseCase {
    public function getTurnosByAtencion(GetTurnosByAtencionRequest $request): GetTurnosByAtencionResponse;
}
                                  
