<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetTurnosByAtencion/Dto/GetTurnosByAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetTurnosByAtencion/Dto/GetTurnosByAtencionResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Queries/IGetTurnosByAtencionQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Repositories/ITurnoRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/TurnoStatusEnum.php";

class GetTurnosByAtencionQueryHandler implements IGetTurnosByAtencionQuery
{

    private $turnoRepository;

    public function __construct(ITurnoRepository $turnoRepository)
    {
        $this->turnoRepository = $turnoRepository;
    }

    public function handler(GetTurnosByAtencionRequest $request): GetTurnosByAtencionResponse
    {
        $turnos = $this->turnoRepository->findByAtencion($request->getAtencionId());
        if (count($turnos) == 0) {
            throw new NotFoundEntryException("No existen Turnos para la Atencion Id: " . $request->getAtencionId());
        }
        $turnosDto = array();
        $totalTurnos = $turnos[0]->atencion->total_turnos;
        $turnosAsingados = @count($turnos[0]->atencion->turnos);
        $turnosCreados = 0;
        $turnosUsados = 0;
        $turnosLiberados = 0;
        $turnosFinalizados = 0;
        $atencionId = $request->getAtencionId();
        foreach ($turnos as $turno) {
            $turnosDto[] = new GetTurnosByAtencionDto(
                $turno->id,
                $turno->numero,
                $turno->estado,
                ($turno->fecha_uso != null) ? new DateTime($turno->fecha_uso) : null ,
                $turno->usuario_uso,
                ($turno->fecha_salida != null) ? new DateTime($turno->fecha_salida) : null ,
                $turno->usuario_salida,
                ($turno->fecha_regreso != null) ? new DateTime($turno->fecha_regreso) : null ,
                $turno->usuario_regreso,
                $turno->observaciones,
                $turno->guia_id,
                $turno->guia->nombres. " ".$turno->guia->apellidos,
                ($turno->fecha_registro != null) ? new DateTime($turno->fecha_registro) : null ,
                $turno->usuario_registro
            );
            $turnosCreados += ($turno->estado === TurnoStatusEnum::CREATED) ? 1 : 0;
            $turnosUsados += ($turno->estado === TurnoStatusEnum::INUSE) ? 1 : 0;
            $turnosLiberados += ($turno->estado === TurnoStatusEnum::RELEASE) ? 1 : 0;
            $turnosFinalizados += ($turno->estado === TurnoStatusEnum::FINALIZED) ? 1 : 0;
        }
        return new GetTurnosByAtencionResponse(
            $totalTurnos,
            $atencionId,
            $turnosAsingados,
            $turnosCreados,
            $turnosUsados,
            $turnosLiberados,
            $turnosFinalizados,
            $turnosDto
        );
    }
}