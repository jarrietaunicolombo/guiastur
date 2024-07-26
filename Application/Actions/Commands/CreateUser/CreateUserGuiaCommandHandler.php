<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Commands/ICreateUserCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Repositories/IGuiaRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserGuiaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserGuiaResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Guia.php";

class CreateUserGuiaCommandHandler implements ICreateUserCommand
{
    private $guiaRepository;

    public function __construct(IGuiaRepository $guiaRepository)
    {
        $this->guiaRepository = $guiaRepository;
    }

    public function handler(CreateUserRequest $request): CreateUserResponse
    {
        $guia = new Guia();

        $guia->cedula = $request->getCedula();
        $guia->rnt = $request->getRnt();
        $guia->nombres = $request->getNombres();
        $guia->apellidos = $request->getApellidos();
        $guia->fecha_nacimiento = $request->getFechaNacimiento();
        $guia->genero = $request->getGenero();
        $guia->telefono = $request->getTelefono();
        $guia->usuario_id = $request->getCedula();
        $guia->usuario_id = $request->getId();
        $guia->fecha_registro = $request->getFechaRegistro();
        $guia->usuario_registro = $request->getUsuarioRegistro();
        $guia = $this->guiaRepository->create($guia);
        return new CreateUserGuiaResponse(
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