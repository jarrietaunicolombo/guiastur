<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateUserGuiaCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IGuiaRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserGuiaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserGuiaResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Guia.php";

class CreateUserGuiaCommandHandler implements ICreateUserGuiaCommand {
    private $guiaRepository;

    public function __construct(IGuiaRepository $guiaRepository) {
        $this->guiaRepository = $guiaRepository;
    }

    public function handler(CreateUserGuiaRequest $request) : CreateUserGuiaResponse {
        $guia = new Guia();
        $guia->cedula = $request->getCedula();
        $guia->rnt = $request->getRnt();
        $guia->nombres = $request->getUsuario()->getUsuario()->getNombre();
        $guia->apellidos ="---";
        $guia->usuario_id = $request->getUsuario()->getId();
        $guia->fecha_registro = $request->getFechaRegistro();
        $guia->usuario_registro = $request->getUsuario()->getUsuario()->getUsuarioRegistro();

        $guia = $this->guiaRepository->create($guia);

        return  new CreateUserGuiaResponse($request);
    }
}