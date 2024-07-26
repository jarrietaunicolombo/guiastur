<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRecaladas/Dto/GetRecaladasResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Queries/IGetRecaladasInThePortQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Repositories/IRecaladaRepository.php";

class GetRecaladasInThePortQueryHandler implements IGetRecaladasInThePortQuery
{

    private $recaladaRepository;

    public function __construct(IRecaladaRepository $recaladaRepository)
    {
        $this->recaladaRepository = $recaladaRepository;
    }

    public function handler(): GetRecaladasResponse
    {
        $recaladas = $this->recaladaRepository->findRecaladaInThePort();
        $getRecaladasInThePort = array();
        foreach ($recaladas as $recalada) {
            $getRecaladasInThePort[] = new RecaladaResponseDto(
                $recalada->id,
                $recalada->buque->id,
                $recalada->buque->nombre,
                ($recalada->fecha_arribo != null) ? new \DateTime($recalada->fecha_arribo) : null ,
                ($recalada->fecha_zarpe != null) ? new \DateTime($recalada->fecha_zarpe) : null ,
                $recalada->total_turistas,
                $recalada->pais->id,
                $recalada->pais->nombre,
                $recalada->observaciones,
                @count($recalada->atencions)
            );
        }
        return new GetRecaladasResponse($getRecaladasInThePort);
    }
}