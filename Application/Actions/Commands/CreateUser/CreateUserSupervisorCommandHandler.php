<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateUserCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/ISupervisorRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserSupervisorRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserSupervisorResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Supervisor.php";

class CreateUserSupervisorCommandHandler implements ICreateUserCommand {
    private $supervisorRepository;

    public function __construct(ISupervisorRepository $supervisorRepository) {
        $this->supervisorRepository = $supervisorRepository;
    }

    public function handler(CreateUserRequest $request) : CreateUserResponse {
        $supervisor = new Supervisor();

        $supervisor->cedula = $request->getCedula();
        $supervisor->rnt = $request->getRnt();
        $supervisor->nombres = $request->getNombres();
        $supervisor->apellidos = $request->getApellidos();
        $supervisor->fecha_nacimiento = $request->getFechaNacimiento();
        $supervisor->genero = $request->getGenero();
        $supervisor->telefono = $request->getTelefono();
        $supervisor->usuario_id = $request->getId();
        $supervisor->fecha_registro = $request->getFechaRegistro();
        $supervisor->usuario_registro = $request->getUsuarioRegistro();
        $supervisor = $this->supervisorRepository->create($supervisor);
        return new CreateUserSupervisorResponse(
                $request->getId(),
                $request->getEmail(),
                $request->getPassword(),
                $request->getNombre(),
                $request->getEstado(),
                $request->getRolId(),
                $request->getRolNombre(),
                $request->getValidationToken(),
                $request->getCedula(),
                $request->getRnt(),
                $request->getNombres(),
                $request->getApellidos(),
                $request->getGenero(),
                $request->getFechaNacimiento(),
                $request->getTelefono(),
                $request->getFoto(),
                $request->getObservaciones(),
                $request->getUsuarioRegistro(),
                $request->getFechaRegistro()
        );
    }
}