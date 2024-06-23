<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateTurno/Dto/CreateTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateTurno/Dto/CreateTurnoResponse.php";

interface ICreateTurnoUseCase  {
    
   public function CreateTurno(CreateTurnoRequest $request) : CreateTurnoResponse;
    
}