<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/EndTurno/Dto/EndTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/EndTurno/Dto/EndTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/IEndTurnoCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/ITurnoRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Turno.php";

class EndTurnoCommandHandler implements IEndTurnoCommand{
    private $turnoRepository;
    public function __construct(ITurnoRepository $turnoRepository)
    {
        $this->turnoRepository = $turnoRepository;
    }

    public function handler(EndTurnoRequest $request) : EndTurnoResponse{
        $estado = "Finalizado";
        $turno = $this->turnoRepository->find($request->getTurnoId());
        $turno->estado = $estado;
        $turno->fecha_regreso = new DateTime();
        $turno->usuario_regreso = $request->getUsuarioIdUso();
        $turno = $this->turnoRepository->update($turno);
        return new EndTurnoResponse(
            $turno->id,
            $turno->numero,
            $turno->estado,
            $turno->fecha_uso,
            $turno->usuario_uso,
            $turno->fecha_salida,
            $turno->usuario_salida,
            $turno->fecha_regreso,
            $turno->usuario_regreso,
            $turno->observaciones,
            new GuiaEndTurnoDto(
                $turno->guia->usuario->id,
                $turno->guia->cedula,
                $turno->guia->rnt,
                $turno->guia->nombres . " " . $turno->guia->apellidos,
                $turno->guia->telefono,
                $turno->guia->foto
            ),
            new AtencionEndTurnoDto(
                $turno->atencion->id,
                $turno->atencion->fecha_inicio,
                $turno->atencion->fecha_cierre,
                $turno->atencion->total_turnos
            ),
            $turno->fecha_registro,
            $turno->usuario_registro
        );
    }

}
