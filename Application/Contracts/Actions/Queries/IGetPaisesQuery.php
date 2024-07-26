<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetPaises/Dto/GetPaisesResponse.php";

interface IGetPaisesQuery{
    public function handler() : GetPaisesResponse;
    
}