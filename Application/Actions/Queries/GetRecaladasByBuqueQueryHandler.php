<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRecaladasByBuque/Dto/GetRecaladasByBuqueRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRecaladas/Dto/GetRecaladasResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetRecaladasByBuqueQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IRecaladaRepository.php";

class GetRecaladasByBuqueQueryHandler implements IGetRecaladasByBuqueQuery{

    private $recaladaRepository;

    public function __construct(IRecaladaRepository $recaladaRepository)
    {
        $this->recaladaRepository = $recaladaRepository;
    }

    public function handler(GetRecaladasByBuqueRequest $request) : GetRecaladasResponse{    
        $recaladasEntity = $this->recaladaRepository->findByBuqueId($request->getBuqueId());
        $recladasDto = array();
        foreach($recaladasEntity as $recalada){
            $recladasDto[] = new RecaladaResponseDto(
                $recalada->id,
                $recalada->buque->id,
                $recalada->buque->nombre,
                new \DateTime($recalada->fecha_arribo),
                new \DateTime($recalada->fecha_zarpe),
                $recalada->total_turistas,
                $recalada->pais->id,
                $recalada->pais->nombre,
                $recalada->observaciones,
                count($recalada->atencions)
            );
        }
        return new GetRecaladasResponse($recladasDto);
    }
}
