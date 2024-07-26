<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRoles/Dto/GetRolesResponse.php";

interface IGetRolesQuery{
    public function handler() : GetRolesResponse;
    
}