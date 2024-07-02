<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetUsuarioById/Dto/GetUsuarioByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetUsuarioById/Dto/GetUsuarioByIdResponse.php";

interface IGetUsuarioByIdQuery{
    public function handler(GetUsuarioByIdRequest $request) : GetUsuarioByIdResponse;
}