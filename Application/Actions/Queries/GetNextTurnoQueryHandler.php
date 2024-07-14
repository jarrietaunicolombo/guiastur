<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetNextTurno/Dto/GetNextTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetNextTurno/Dto/GetNextTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetNextTurnoQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/ITurnoRepository.php";

class GetNextTurnoQueryHandler implements IGetNextTurnoQuery{

    private $turnoRepository;
    public function __construct(ITurnoRepository $turnoRepository) {
        $this->turnoRepository = $turnoRepository;
    }
    public function handler(GetNextTurnoRequest $request) : GetNextTurnoResponse{
        $turno = $this->turnoRepository->findNexTurno($request->getAtencionId());
        return new GetNextTurnoResponse(
            $turno->id,
            $turno->numero,
            $turno->estado,
            ($turno->fecha_uso != null) ? new \DateTime($turno->fecha_uso) : null ,
            $turno->usuario_uso,
            ($turno->fecha_salida != null) ? new \DateTime($turno->fecha_salida) : null ,
            $turno->usuario_salida,
            ($turno->fecha_regreso != null) ? new \DateTime($turno->fecha_regreso) : null ,
            $turno->usuario_regreso,
            $turno->observaciones,
            new GuiaDto(
                $turno->guia->usuario->id,
                $turno->guia->cedula,
                $turno->guia->rnt,
                $turno->guia->nombres . " " . $turno->guia->apellidos,
                $turno->guia->telefono,
                $turno->guia->foto
            ),
            new AtencionDto(
                $turno->atencion->id,
                ($turno->atencion->fecha_inicio != null) ? new \DateTime($turno->atencion->fecha_inicio) : null ,
                ($turno->atencion->fecha_cierre != null) ? new \DateTime($turno->atencion->fecha_cierre) : null ,
                $turno->atencion->total_turnos
            ),
            ($turno->fecha_registro != null) ? new \DateTime($turno->fecha_registro) : null ,
            $turno->usuario_registro
        );
    }
}