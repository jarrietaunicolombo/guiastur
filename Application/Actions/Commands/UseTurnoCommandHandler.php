<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Constants/TurnoStatusEnum.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/UseTurno/Dto/UseTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/UseTurno/Dto/UseTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/IUseTurnoCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/ITurnoRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Turno.php";

class UseTurnoCommandHandler implements IUseTurnoCommand{

    private $turnoRepository;
    public function __construct(ITurnoRepository $turnoRepository)
    {
        $this->turnoRepository = $turnoRepository;
    }

    public function handler(UseTurnoRequest $request) : UseTurnoResponse{
        $estado = TurnoStatusEnum::INUSE;
        $turno = $this->turnoRepository->find($request->getTurnoId());
        $turno->estado = $estado;
        $turno->fecha_uso = new DateTime();
        $turno->usuario_uso = $request->getUsuarioUsoId();
        $observaciones =  $request->getObservaciones() ?? null;
        $turno->observaciones = (isset($observaciones) && !empty(trim($observaciones)))? "Usado: ".$observaciones : null;
        $turno = $this->turnoRepository->update($turno);
        return new UseTurnoResponse(
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
            new GuiaUseTurnoDto(
                $turno->guia->cedula,
                $turno->guia->rnt,
                $turno->guia->nombres . " " . $turno->guia->apellidos,
                $turno->guia->telefono,
                $turno->guia->foto
            ),
            new AtencionUseTurnoDto(
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
