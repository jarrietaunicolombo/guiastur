<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetTurnoById/Dto/GetTurnoByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetTurnoById/Dto/GetTurnoByIdResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Queries/IGetTurnoByIdQuery.php";

class GetTurnoByIdQueryHandler implements IGetTurnoByIdQuery
{

    private $turnoRepository;

    public function __construct(ITurnoRepository $turnoRepository)
    {
        $this->turnoRepository = $turnoRepository;
    }

    public function handler(GetTurnoByIdRequest $request): GetTurnoByIdResponse
    {
        $turno = $this->turnoRepository->find($request->getTurnoId());

        return new GetTurnoByIdResponse(
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
            new GuiaTurnoDto(
                $turno->guia->usuario->id,
                $turno->guia->cedula,
                $turno->guia->rnt,
                $turno->guia->nombres . " ". $turno->guia->apellidos,
                $turno->guia->telefono,
                $turno->guia->foto
            ),
            new AtencionTurnoDto(
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