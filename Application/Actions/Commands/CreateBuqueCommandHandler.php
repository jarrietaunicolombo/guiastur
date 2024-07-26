<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateBuque/Dto/CreateBuqueRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateBuque/Dto/CreateBuqueResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Commands/ICreateBuqueCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Repositories/IBuqueRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Buque.php";

class CreateBuqueCommandHandler implements ICreateBuqueCommand {
    private $buqueRepository;

    public function __construct(IBuqueRepository $buqueRepository) {
        $this->buqueRepository = $buqueRepository;
    }

    public function handler(CreateBuqueRequest $request) : CreateBuqueResponse {
        $buque = new Buque();
        $buque->codigo = $request->getCodigo();
        $buque->nombre = $request->getNombre();
        $buque->fecha_registro = $request->getFechaRegistro();
        $buque->usuario_registro = $request->getUsuarioRegistro();
        $buque = $this->buqueRepository->create($buque);
        return  new CreateBuqueResponse($buque->id);
    }
}