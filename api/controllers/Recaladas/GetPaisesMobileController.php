<?php

namespace Api\Controllers\Recaladas;

use Api\Middleware\Response\ResponseMiddleware;
use Exception;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/middleware/Response/ResponseMiddleware.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetPaises/GetPaisesService.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Actions/Queries/GetPaisesQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/PaisRepository.php";

class GetPaisesMobileController
{
    private $getPaisesService;

    public function __construct()
    {
        $getPaisesQueryHandler = new \GetPaisesQueryHandler(new \PaisRepository());

        $this->getPaisesService = new \GetPaisesService($getPaisesQueryHandler);
    }

    public function handleRequest()
    {
        try {
            $paisesResponse = $this->getPaisesService->getPaises();

            $paisesArray = $this->convertPaisesToArray($paisesResponse);

            ResponseMiddleware::success($paisesArray);
        } catch (Exception $e) {
            ResponseMiddleware::error($e->getMessage(), 500);
        }
    }

    private function convertPaisesToArray($paisesResponse)
    {
        try {
            if (method_exists($paisesResponse, 'getPaises')) {
                $paises = $paisesResponse->getPaises();
            } else {
                error_log("El método 'getPaises' no existe en la respuesta.");
                $paises = [];
            }

            error_log("Contenido de getPaises: " . print_r($paises, true));

            $paisesArray = [];
            if (is_array($paises)) {
                foreach ($paises as $pais) {
                    $paisesArray[] = [
                        'id' => utf8_encode($pais->getId()),
                        'nombre' => utf8_encode($pais->getNombre()),
                        'bandera' => utf8_encode($pais->getBandera())
                    ];
                }
            }

            error_log("Array de países para enviar: " . print_r($paisesArray, true));

            return $paisesArray;
        } catch (Exception $e) {
            error_log("Error al convertir países a array: " . $e->getMessage());
            return [];
        }
    }


}
