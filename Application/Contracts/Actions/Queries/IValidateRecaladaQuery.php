<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateRecalada/Dto/ValidaRecaladaRequest.php";

interface IValidateRecaladaQuery{
    public function handler(ValidateRecaldaRequest $request) : bool;
}