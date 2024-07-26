<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladas/Dto/GetRecaladasResponse.php";

interface IGetRecaladasQuery{
    public function handler() : GetRecaladasResponse;
}