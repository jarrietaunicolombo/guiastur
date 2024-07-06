<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRoles/Dto/GetRolesResponse.php";

interface IGetRolesService {
    public function getRoles(): GetRolesResponse;
}
                                  
