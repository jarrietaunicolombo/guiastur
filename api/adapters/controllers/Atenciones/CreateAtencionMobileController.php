<?php

namespace Api\Controllers\Atenciones;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Atenciones/AtencionService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Authentication/AuthMiddleware.php";

use Api\Middleware\Authentication\AuthMiddleware;
use Api\Services\Atenciones\AtencionService;

class CreateAtencionMobileController
{
    private $atencionService;

    public function __construct()
    {
        $this->atencionService = new AtencionService();
    }

    public function handleRequest()
    {
        header("Content-Type: application/json");


        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
            exit;
        }

        $user = AuthMiddleware::authenticate();

        if (!$user) {
            http_response_code(401);
            echo json_encode(["error" => "No autorizado"]);
            exit;
        }


        $input = json_decode(file_get_contents("php://input"), true);

        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input) {
            http_response_code(400);
            echo json_encode(["error" => "Datos inválidos o faltantes"]);
            exit;
        }
        
        try {
            $atencion = $this->atencionService->createAtencion($input);
        
            http_response_code(201);
            echo json_encode(["message" => "Atención creada exitosamente", "atencion" => $atencion]);
        } catch (\Exception $e) {
            http_response_code(400);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}
