<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetBuques/Dto/GetBuquesResponse.php";

interface IGetBuquesService  {
    
   public function getBuques() : GetBuquesResponse;
    
}