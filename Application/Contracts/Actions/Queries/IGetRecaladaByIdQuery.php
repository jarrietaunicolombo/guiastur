<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladas/Dto/GetRecaladasResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladaById/Dto/GetRecaladaByIdRequest.php";

interface IGetRecaladaByIdQuery{
    public function handler(GetRecaladaByIdRequest $request) : RecaladaResponseDto;
}