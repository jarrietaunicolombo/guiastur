<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Constants/TurnoStatusEnum.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/FinishTurno/Dto/FinishTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/FinishTurno/Dto/FinishTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/IFinishTurnoCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/ITurnoRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Turno.php";

class FinishTurnoCommandHandler implements IFinishTurnoCommand{
    private $turnoRepository;
    public function __construct(ITurnoRepository $turnoRepository)
    {
        $this->turnoRepository = $turnoRepository;
    }

    public function handler(FinishTurnoRequest $request) : FinishTurnoResponse{
        $estado = TurnoStatusEnum::FINALIZED;
        $turno = $this->turnoRepository->find($request->getTurnoId());
        $turno->estado = $estado;
        $turno->fecha_regreso = new DateTime();
        $turno->usuario_regreso = $request->getUsuarioIdUso();
        $observaciones =  $request->getObservaciones();
        if($turno->observaciones && $observaciones && !empty(trim($observaciones))){
            $turno->observaciones .= ". Finalizado: $observaciones";
        }
        if(!$turno->observaciones && $observaciones && !empty(trim($observaciones))){
            $turno->observaciones = "Finalizado: $observaciones";
        }
        $turno = $this->turnoRepository->update($turno);
        return new FinishTurnoResponse(
            $turno->id,
            $turno->numero,
            $turno->estado,
            new DateTime($turno->fecha_regreso),
            $turno->usuario_regreso,
            $turno->observaciones
        );
    }

}
