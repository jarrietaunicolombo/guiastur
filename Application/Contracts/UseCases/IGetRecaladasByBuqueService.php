<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRecaladasByBuque/Dto/GetRecaladasByBuqueRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRecaladas/Dto/GetRecaladasResponse.php";

interface IGetRecaladasByBuqueService{
    public function getRecaladasByBuque(GetRecaladasByBuqueRequest $request) : GetRecaladasResponse;
}
