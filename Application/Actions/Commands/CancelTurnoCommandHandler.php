<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Constants/TurnoStatusEnum.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CancelTurno/Dto/CancelTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CancelTurno/Dto/CancelTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICancelTurnoCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/ITurnoRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Turno.php";

class CancelTurnoCommandHandler implements ICancelTurnoCommand{
    private $turnoRepository;
    public function __construct(ITurnoRepository $turnoRepository)
    {
        $this->turnoRepository = $turnoRepository;
    }

    public function handler(CancelTurnoRequest $request) : CancelTurnoResponse{
        $estado = TurnoStatusEnum::CANCELLED;
        $turno = $this->turnoRepository->find($request->getTurnoId());
        $turno->estado = $estado;
        $observaciones = ($turno->obsevaciones !== NULL)
                            ?  $turno->obsevaciones . "\n".TurnoStatusEnum::CANCELLED .": ". $request->getObservaciones() 
                            : TurnoStatusEnum::CANCELLED .": ". $request->getObservaciones();
        $turno->obsevaciones = $observaciones;
        $turno->fecha_regreso = new DateTime();
        $turno->usuario_regreso = $request->getUsuarioCancelId();
        $turno = $this->turnoRepository->update($turno);
        return new CancelTurnoResponse(
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
            new GuiaCancelTurnoDto(
                $turno->guia->usuario->id,
                $turno->guia->cedula,
                $turno->guia->rnt,
                $turno->guia->nombres . " " . $turno->guia->apellidos,
                $turno->guia->telefono,
                $turno->guia->foto
            ),
            new AtencionCancelTurnoDto(
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
