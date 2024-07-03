<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/ReleaseTurno/Dto/ReleaseTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/ReleaseTurno/Dto/ReleaseTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/IReleaseTurnoCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/ITurnoRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Turno.php";

class ReleaseTurnoCommandHandler implements IReleaseTurnoCommand{

    private $turnoRepository;
    public function __construct(ITurnoRepository $turnoRepository)
    {
        $this->turnoRepository = $turnoRepository;
    }

    public function handler(ReleaseTurnoRequest $request) : ReleaseTurnoResponse{
        $estado = "Liberado";
        $turno = $this->turnoRepository->find($request->getTurnoId());
        $turno->estado = $estado;
        $turno->fecha_salida = new DateTime();
        $turno->usuario_salida = $request->getUsuarioIdUso();
        $turno = $this->turnoRepository->update($turno);
        return new ReleaseTurnoResponse(
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
            new GuiaReleaseTurnoDto(
                $turno->guia->usuario->id,
                $turno->guia->cedula,
                $turno->guia->rnt,
                $turno->guia->nombres . " " . $turno->guia->apellidos,
                $turno->guia->telefono,
                $turno->guia->foto
            ),
            new AtencionReleaseTurnoDto(
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
