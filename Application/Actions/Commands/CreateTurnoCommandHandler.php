<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateTurno/Dto/CreateTurnoRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateTurno/Dto/CreateTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateTurnoCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateTurnoCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/ITurnoRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Turno.php";

class CreateTurnoCommandHandler implements ICreateTurnoCommand{
    private $turnoRepository;

    public function __construct(ITurnoRepository $turnoRepository){
        $this->turnoRepository = $turnoRepository; 
    }
    public function handler(CreateTurnoRequest $request) : CreateTurnoResponse{
        $turno = new Turno();
        $turno->numero = $request->getNumero();
        $turno->estado = $request->getEstado();
        $turno->observaciones = $request->getObservaciones();
        $turno->guia_id = $request->getGuiaId();
        $turno->atencion_id = $request->getAtencionId();
        $turno->fecha_registro = $request->getFechaRegistro();
        $turno->usuario_registro = $request->getUsuarioRegistro();
        $turno = $this->turnoRepository->create($turno);
        return new CreateTurnoResponse($turno->id, $request);
    }
}