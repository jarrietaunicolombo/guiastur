<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetAtencionesByRecalada/Dto/GetAtencionesByRecaladaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetAtencionesByRecalada/Dto/GetAtencionesByRecaladaResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetAtencionesByRecaladaQuery.php";



interface IGetAtencionesByRecaladaUseCase  {
    
   public function getAtencionesByRecalada(GetAtencionesByRecaladaRequest $request) : GetAtencionesByRecaladaResponse;
    
}