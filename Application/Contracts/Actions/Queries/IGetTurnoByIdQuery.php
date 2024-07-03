<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnoById/Dto/GetTurnoByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnoById/Dto/GetTurnoByIdResponse.php";

interface IGetTurnoByIdQuery{
    public function handler(GetTurnoByIdRequest $request) : GetTurnoByIdResponse;
}