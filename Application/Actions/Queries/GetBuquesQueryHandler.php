<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetBuques/Dto/GetBuquesResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetBuquesQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IBuqueRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Buque.php";

class GetBuquesQueryHandler implements IGetBuquesQuery
{

    private $buqueRepository;
    public function __construct(IBuqueRepository $buqueRepository)
    {
        $this->buqueRepository = $buqueRepository;
    }

    public function handler(): GetBuquesResponse
    {
        $buquesEntities = $this->buqueRepository->findAll();
        $buquesResonseDto = array();
        foreach ($buquesEntities as $buqueEntity) {
            $recaladas = $buqueEntity->recaladas;
            $total_atenciones = 0;
            foreach ($recaladas as $recaladaEntity) {
                $total_atenciones += count($recaladaEntity->atencions);
            }
            $buquesResonseDto[] = new BuqueResponseDto(
                $buqueEntity->id,
                $buqueEntity->codigo,
                $buqueEntity->nombre,
                $buqueEntity->foto,
                count($recaladas),
                $total_atenciones
            );
        }
        return new GetBuquesResponse($buquesResonseDto);

    }
}