<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladasByBuque/Dto/GetRecaladasByBuqueRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladas/Dto/GetRecaladasResponse.php";

interface IGetRecaladasByBuqueQuery{
    public function handler(GetRecaladasByBuqueRequest $request) : GetRecaladasResponse;
}
