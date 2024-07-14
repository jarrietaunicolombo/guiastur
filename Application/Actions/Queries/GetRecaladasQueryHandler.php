<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRecaladas/Dto/GetRecaladasResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetRecaladasQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IRecaladaRepository.php";

class GetRecaladasQueryHandler implements IGetRecaladasQuery
{

    private $recaladaRepository;

    public function __construct(IRecaladaRepository $recaladaRepository)
    {
        $this->recaladaRepository = $recaladaRepository;
    }

    public function handler(): GetRecaladasResponse
    {
        $recaladas = $this->recaladaRepository->findAll();
        $recaladasEntities = array();
        foreach ($recaladas as $recalada) {
            $recaladasEntities[] = new RecaladaResponseDto(
                $recalada->id,
                $recalada->buque->id,
                $recalada->buque->nombre,
                ($recalada->fecha_arribo != null) ? new \DateTime($recalada->fecha_arribo) : null ,
                ($recalada->fecha_zarpe != null) ? new \DateTime($recalada->fecha_zarpe) : null ,
                $recalada->total_turistas,
                $recalada->pais->id,
                $recalada->pais->nombre,
                $recalada->observaciones,
                count($recalada->atencions)
            );
        }
        return new GetRecaladasResponse($recaladasEntities);
    }
}