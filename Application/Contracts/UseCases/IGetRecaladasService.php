<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladas/Dto/GetRecaladasResponse.php";

interface IGetRecaladasService {
    public function getRecaladas(): GetRecaladasResponse;
}
                                  
