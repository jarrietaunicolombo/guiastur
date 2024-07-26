<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetPaises/Dto/GetPaisesResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Queries/IGetPaisesQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Repositories/IPaisRepository.php";

class GetPaisesQueryHandler implements IGetPaisesQuery {
    private $paisesRepository;
    public function __construct(IPaisRepository $paisesRepository) {
        $this->paisesRepository = $paisesRepository;
    }

    public function handler() : GetPaisesResponse {
        $paisesEntity = $this->paisesRepository->findAll();
        $paisList = array();
        foreach ($paisesEntity as $pais) {
            $paisList[] = new PaisResponse(
                $pais->id,
                $pais->nombre,
                $pais->bandera
            );
        }
        return new GetPaisesResponse($paisList);
    }
}
