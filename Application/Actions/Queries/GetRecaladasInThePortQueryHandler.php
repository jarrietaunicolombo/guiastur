<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRecaladasInThePort/Dto/GetRecaladasInThePortResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetRecaladasInThePortQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IRecaladaRepository.php";

class GetRecaladasInThePortQueryHandler implements IGetRecaladasInThePortQuery
{

    private $recaladaRepository;

    public function __construct(IRecaladaRepository $recaladaRepository)
    {
        $this->recaladaRepository = $recaladaRepository;
    }

    public function handler(): array
    {
        $recaladas = $this->recaladaRepository->findRecaladaInThePort();
        $getRecaladasInThePort = array();
        foreach ($recaladas as $recalada) {
            $getRecaladasInThePort[] = new GetRecaladasInThePortResponse(
                $recalada->id,
                $recalada->buque->id,
                $recalada->buque->nombre,
                $recalada->fecha_arribo,
                $recalada->fecha_zarpe,
                $recalada->total_turistas,
                $recalada->pais->id,
                $recalada->pais->nombre,
                $recalada->observaciones,
                count($recalada->atencions)
            );
        }
        return $getRecaladasInThePort;
    }
}