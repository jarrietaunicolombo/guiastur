<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetAtencionesByRecalada/Dto/GetAtencionesByRecaladaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetAtencionesByRecalada/Dto/GetAtencionesByRecaladaResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetAtencionesByRecaladaQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IAtencionRepository.php";

class GetAtencionesByRecaladaQueryHandler implements IGetAtencionesByRecaladaQuery
{
    private $recaladaRepository;
    private $buqueRepository;
    private $atencionRepository;

    private $supeerRepository;

    public function __construct(IAtencionRepository $atencionRepository) {
        $this->atencionRepository = $atencionRepository;
    }

    public function handler(GetAtencionesByRecaladaRequest $request): GetAtencionesByRecaladaResponse
    {

        $atencionesEntities = $this->atencionRepository->findByRecalada($request->getId());
        if (count($atencionesEntities) < 1) {
            return new GetAtencionesByRecaladaResponse(NULL, NULL, array());
        }

        $recaladaEntity = $atencionesEntities[0]->recalada;
        $recaladaResponse = new RecaladaResponse($recaladaEntity->id, $recaladaEntity->pais->nombre);
        $buqueResponse = new BuqueResponse($recaladaEntity->buque->id, $recaladaEntity->buque->nombre);
        $atencionesResponseList = array();
        foreach ($atencionesEntities as $atencionEntity) {
            $atencionResponse = new AtencionResponse(
                $atencionEntity->id,
                $atencionEntity->fecha_inicio,
                $atencionEntity->fecha_cierre,
                $atencionEntity->total_turnos,
                count($atencionEntity->turnos),
                ($atencionEntity->total_turnos - count($atencionEntity->turnos)),
                $atencionEntity->observaciones,
                ($atencionEntity->supervisor_id !== null) ? $atencionEntity->supervisor_id : NULL,
                ($atencionEntity->supervisor_id !== null) ? $atencionEntity->supervisor->nombres ." ".  $atencionEntity->supervisor->apellidos  : NULL
            );
            $atencionesResponseList[] = $atencionResponse;
        }
        return new GetAtencionesByRecaladaResponse($buqueResponse, $recaladaResponse, $atencionesResponseList);
    }
}


