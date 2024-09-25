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
        if (method_exists($paisesResponse, 'getPaises')) {
            $paises = $paisesResponse->getPaises();
        } else {
            $paises = [];
        }

        $paisesArray = [];
        if (is_array($paises)) {
            foreach ($paises as $pais) {
                $paisesArray[] = [
                    'id' => $pais->getId(),
                    'nombre' => $pais->getNombre(),
                    'bandera' => $pais->getBandera()
                ];
            }
        }

        return $paisesArray;
    }
}
