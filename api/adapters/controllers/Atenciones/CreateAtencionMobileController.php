<?php

namespace Api\Controllers\Atenciones;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/services/Atenciones/AtencionService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/adapters/middleware/Authentication/AuthMiddleware.php";

use Api\Middleware\Authentication\AuthMiddleware;

class CreateAtencionMobileController
{
    private $atencionService;

    public function __construct()
    {
        error_log("📌 Iniciando CreateAtencionMobileController...");
        $this->atencionService = new \AtencionService();
    }

    public function handleRequest()
    {
        header("Content-Type: application/json");

        error_log("📌 Método de la petición: " . $_SERVER["REQUEST_METHOD"]);

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            error_log("❌ Método no permitido");
            http_response_code(405);
            echo json_encode(["error" => "Método no permitido"]);
            exit;
        }

        error_log("📌 Iniciando autenticación...");
        $user = AuthMiddleware::authenticate();

        if (!$user) {
            error_log("❌ Autenticación fallida, usuario no autorizado.");
            http_response_code(401);
            echo json_encode(["error" => "No autorizado"]);
            exit;
        }

        error_log("✅ Usuario autenticado: " . json_encode($user));

        $input = json_decode(file_get_contents("php://input"), true);

        if (!$input) {
            error_log("❌ Error: JSON inválido recibido.");
            error_log("📌 Datos recibidos: " . file_get_contents("php://input"));
            http_response_code(400);
            echo json_encode(["error" => "Datos inválidos o faltantes"]);
            exit;
        }

        error_log("✅ Datos recibidos correctamente: " . json_encode($input));

        try {
            $atencion = $this->atencionService->createAtencion($input);
            error_log("✅ Atención creada exitosamente");

            http_response_code(201);
            echo json_encode(["message" => "Atención creada exitosamente", "atencion" => $atencion]);
        } catch (\Exception $e) {
            error_log("❌ Excepción en CreateAtencionMobileController: " . $e->getMessage());
            http_response_code(400);
            echo json_encode(["error" => $e->getMessage()]);
        }
    }
}
