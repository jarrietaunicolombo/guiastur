<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateAtencion/Dto/CreateAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateAtencion/Dto/CreateAtencionResponse.php";

interface ICreateAtencionCommand {
    public function handler(CreateAtencionRequest $request) : CreateAtencionResponse;
}