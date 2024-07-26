<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladas/Dto/GetRecaladasResponse.php";

interface IGetRecaladasInThePortUseCase {
    public function getRecaladasInThePort(): GetRecaladasResponse;
}
                                  
