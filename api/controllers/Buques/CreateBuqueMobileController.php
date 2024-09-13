<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/CookiesSetup.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Exceptions/UnauthorizedException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateBuque/Dto/CreateBuqueRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateBuque/CreateBuqueUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Services/Auth/AuthService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Authorization/AuthorizationMiddleware.php";

use Api\Services\AuthService;
use Api\Exceptions\UnauthorizedException;

class CreateBuqueMobileController
{
    private $createBuqueService;
    private $authService;

    public function __construct()
    {
        $this->createBuqueService = DependencyInjection::getCreateBuqueServce();
        $this->authService = new AuthService();
    }

    public function handleRequest(array $request)
    {
        if ($request["action"] !== "create") {
            error_log("Acción no permitida: " . $request["action"]);
            $this->sendErrorResponse("Acción no permitida", 403);
            return;
        }

        $this->createBuque($request);
    }

    private function createBuque(array $request)
    {
        try {
            $headers = apache_request_headers();
            $authHeader = $headers['Authorization'] ?? '';
            if (!$authHeader) {
                error_log("Error: Token de autorización no proporcionado.");
                throw new UnauthorizedException("Token de autorización no proporcionado.");
            }

            error_log("Validando token JWT: " . $authHeader);
            $decodedToken = $this->authService->validateToken($authHeader);
            if (!$decodedToken) {
                error_log("Error: Token inválido.");
                throw new UnauthorizedException("Token inválido.");
            }

            error_log("Token decodificado: " . print_r($decodedToken, true));

            $userId = $decodedToken->data->userId;
            $userRole = $decodedToken->data->role;

            error_log("Verificando permisos para el rol: " . $userRole);
            AuthorizationMiddleware::checkRolePermission($userRole, ['ADMIN', 'Super Usuario']);

            $codigo = $request['codigo'] ?? null;
            $nombre = $request['nombre'] ?? null;

            if (!$codigo || !$nombre) {
                error_log("Error: Faltan datos obligatorios (codigo: $codigo, nombre: $nombre).");
                throw new \InvalidArgumentException("Faltan datos obligatorios para crear el buque.");
            }

            error_log("Creando objeto CreateBuqueRequest con codigo: $codigo, nombre: $nombre.");
            $createRequest = new CreateBuqueRequest($codigo, $nombre, null, $userId);

            error_log("Llamando al servicio CreateBuqueService.");
            $response = $this->createBuqueService->CreateBuque($createRequest);

            error_log("Buque creado exitosamente. Respuesta: " . $response->toJSON());
            $this->sendSuccessResponse($response->toJSON());
        } catch (UnauthorizedException $e) {
            error_log("UnauthorizedException: " . $e->getMessage());
            $this->sendErrorResponse($e->getMessage(), 401);
        } catch (\InvalidArgumentException $e) {
            error_log("InvalidArgumentException: " . $e->getMessage());
            $this->sendErrorResponse($e->getMessage(), 400);
        } catch (\Exception $e) {
            error_log("Error general: " . $e->getMessage());
            $this->sendErrorResponse("Error interno del servidor", 500);
        }
    }

    private function sendSuccessResponse($data)
    {
        header('Content-Type: application/json');
        echo json_encode([
            "status" => "success",
            "data" => $data
        ]);
        exit;
    }

    private function sendErrorResponse($message, $statusCode)
    {
        header('Content-Type: application/json', true, $statusCode);
        echo json_encode([
            "status" => "error",
            "message" => $message
        ]);
        exit;
    }
}
