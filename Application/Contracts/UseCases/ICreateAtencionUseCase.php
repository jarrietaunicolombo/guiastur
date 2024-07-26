<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateAtencion/Dto/CreateAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateAtencion/Dto/CreateAtencionResponse.php";

interface ICreateAtencionUseCase  {
    
   public function CreateAtencion(CreateAtencionRequest $request) : CreateAtencionResponse;
    
}