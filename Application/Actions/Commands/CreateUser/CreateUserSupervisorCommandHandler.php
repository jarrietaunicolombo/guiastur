<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateUserSupervisorCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/ISupervisorRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserSupervisorRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserSupervisorResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Supervisor.php";

class CreateUserSupervisorCommandHandler implements ICreateUserSupervisorCommand {
    private $supervisorRepository;

    public function __construct(ISupervisorRepository $supervisorRepository) {
        $this->supervisorRepository = $supervisorRepository;
    }

    public function handler(CreateUserSupervisorRequest $request) : CreateUserSupervisorResponse {
        $supervisor = new Supervisor();
        $supervisor->cedula = $request->getCedula();
        $supervisor->rnt = $request->getRnt();
        $supervisor->nombres = $request->getUsuario()->getUsuario()->getNombre();
        $supervisor->apellidos ="---";
        $supervisor->usuario_id = $request->getUsuario()->getId();
        $supervisor->fecha_registro = $request->getFechaRegistro();
        $supervisor->usuario_registro = $request->getUsuario()->getUsuario()->getUsuarioRegistro();

        $supervisor = $this->supervisorRepository->create($supervisor);

        return  new CreateUserSupervisorResponse($request);
    }
}