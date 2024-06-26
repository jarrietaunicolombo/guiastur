<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetBuqueById/Dto/GetBuqueByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetBuqueById/Dto/GetBuqueByIdResponse.php";

interface IGetBuqueByIdQuery{
    public function handler(GetBuqueByIdRequest $request) : GetBuqueByIdResponse;
}