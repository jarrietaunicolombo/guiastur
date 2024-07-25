<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetAtenciones/Dto/GetAtencionByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetAtenciones/Dto/GetAtencionResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetAtencionByIdQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IAtencionRepository.php";

class GetAtencionByIdQueryHandler implements IGetAtencionByIdQuery
{
    private $atencionRepository;

    public function __construct(IAtencionRepository $atencionRepository)
    {
        $this->atencionRepository = $atencionRepository;
    }

    public function handler(GetAtencionByIdRequest $request): GetAtencionResponse
    {
        $atencionEntity = $this->atencionRepository->find($request->getAtencionId());
        $totalTurnos = $atencionEntity->total_turnos ?? 0;
        $turnosEntities = $atencionEntity->turnos;
        $turnosCreados = 0;

        if (count($turnosEntities) > 0) {
            foreach ($turnosEntities as $turno) {
                if ($turno->estado === TurnoStatusEnum::CREATED) {
                    $turnosCreados += 1;
                }
            }
        }
        $turnosDisponibles = $totalTurnos - $turnosCreados;
        $nombre = ($atencionEntity->supervisor_id !== null) ? $atencionEntity->supervisor->nombres . " " . $atencionEntity->supervisor->apellidos : null;

        return new GetAtencionResponse(
            $atencionEntity->id,
            new DateTime($atencionEntity->fecha_inicio),
            new DateTime($atencionEntity->fecha_cierre),
            $totalTurnos,
            $turnosCreados,
            $turnosDisponibles,
            $atencionEntity->observaciones,
            ($atencionEntity->supervisor_id !== null) ? $atencionEntity->supervisor_id : null,
            $nombre,
            new BuqueResponseDto(
                $atencionEntity->recalada->buque->id,
                $atencionEntity->recalada->buque->nombre
            ),
            new RecaladaResponseDto(
                $atencionEntity->recalada->id,
                new DateTime($atencionEntity->recalada->fecha_arribo),
                new DateTime($atencionEntity->recalada->fecha_zarpe),
                $atencionEntity->recalada->pais->nombre

            )
        );

    }
}
