<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetUsusarioByToken/Dto/UpdateUsuarioByActivatedRequest.php";

interface IUpdateUsuarioByActivatedCommand {
    public function handler(UpdateUsuarioByActivatedRequest $request);
}