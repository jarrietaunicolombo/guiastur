<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateAtecion/Dto/CreateAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateAtecion/Dto/CreateAtencionResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateAtencionCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IAtencionRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Atencion.php";

class CreateAtencionCommandHandler implements ICreateAtencionCommand {
    private $atencionRepository;

    public function __construct(IAtencionRepository $atencionRepository){
        $this->atencionRepository = $atencionRepository;
    }

    public function handler(CreateAtencionRequest $request): CreateAtencionResponse {
        $atencion = new Atencion();
        $atencion->fecha_inicio = $request->getFechaInicio();
        $atencion->fecha_cierre = $request->getFechaCierre();
        $atencion->total_turnos = $request->getTotalTurnos();
        $atencion->observaciones = $request->getObservaciones();
        $atencion->recalada_id = $request->getRecaladaId();
        $atencion->supervisor_id = $request->getSupervisorId();
        $atencion->fecha_registro = $request->getFechaRegistro();
        $atencion->usuario_registro = $request->getUsuarioRegistro();
        $atencion = $this->atencionRepository->create($atencion);
        return new CreateAtencionResponse(
            $atencion->id
            , $request   
        );
    }

}