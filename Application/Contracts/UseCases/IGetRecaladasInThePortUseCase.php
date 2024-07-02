<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRecaladasInThePort/Dto/GetRecaladasInThePortResponse.php";

interface IGetRecaladasInThePortUseCase {
    public function getRecaladasInThePort(): array;
}
                                  
