<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencionUseCase/Dto/GetTurnosByAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencionUseCase/Dto/GetTurnosByAtencionResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetTurnosByAtencionQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/ITurnoRepository.php";

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
        $atencionId = $request->getAtencionId();
        foreach ($turnos as $turno) {
            $turnosDto[] = new GetTurnosByAtencionDto(
                $turno->id,
                $turno->numero,
                $turno->estado,
                $turno->fecha_uso,
                $turno->fecha_salida,
                $turno->fecha_regreso,
                $turno->observaciones,
                $turno->guia_id,
                $turno->fecha_registro,
                $turno->usuario_registro
            );
        }
        return new GetTurnosByAtencionResponse(
            $totalTurnos,
            $atencionId,
            $turnosDto
        );
    }
}