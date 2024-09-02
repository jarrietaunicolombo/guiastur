<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";

class RolesControllerApi
{
    public function getRoles()
    {
        try {
            $rolesService = DependencyInjection::getRolesServce();

            $rolesResponse = $rolesService->getRoles();

            $rolesArray = $rolesResponse->getRoles();

            $roles = array_map(function ($rol) {
                return [
                    'id' => $rol->getId(),
                    'name' => $rol->getNombre(),
                    'description' => $rol->getDescripcion(),
                    'icon' => $rol->getIcono()
                ];
            }, $rolesArray);

            echo json_encode($roles);
            http_response_code(200);
        } catch (Exception $e) {
            echo json_encode(["error" => $e->getMessage()]);
            http_response_code(500);
        }
        exit();
    }
}
