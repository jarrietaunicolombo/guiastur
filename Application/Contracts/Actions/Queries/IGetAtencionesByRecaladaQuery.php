<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application\UseCases\GetAtencionesByRecalada\Dto\GetAtencionesByRecaladaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application\UseCases\GetAtencionesByRecalada\Dto\GetAtencionesByRecaladaResponse.php";

interface IGetAtencionesByRecaladaQuery  {
    
   public function handler(GetAtencionesByRecaladaRequest $request) : GetAtencionesByRecaladaResponse;
    
}