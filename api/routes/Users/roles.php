<?php
header("Access-Control-Allow-Origin: https://localhost:8100");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";

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
