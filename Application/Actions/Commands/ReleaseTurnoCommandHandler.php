<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Constants/TurnoStatusEnum.php";
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
        $estado = TurnoStatusEnum::RELEASE;
        $turno = $this->turnoRepository->find($request->getTurnoId());
        $turno->estado = $estado;
        $turno->fecha_salida = new DateTime();
        $turno->usuario_salida = $request->getUsuarioIdUso();
        $turno->observaciones = $request->getObservaciones();
        $turno = $this->turnoRepository->update($turno);
        return new ReleaseTurnoResponse(
            $turno->id,
            $turno->numero,
            $turno->estado,
            new DateTime($turno->fecha_salida),
            $turno->usuario_salida
        );
    }

}
