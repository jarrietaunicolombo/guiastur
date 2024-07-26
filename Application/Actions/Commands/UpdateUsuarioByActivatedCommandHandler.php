<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Commands/IUpdateUsuarioByActivatedCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetUsusarioByToken/Dto/UpdateUsuarioByActivatedRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetUsusarioByToken/Dto/UpdateUsuarioByActivatedResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Repositories/IUsuarioRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/UsuarioStatus.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Usuario.php";

class UpdateUsuarioByActivatedCommandHandler implements IUpdateUsuarioByActivatedCommand{
    private $usuarioRepository;
    public function __construct(IUsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function handler(UpdateUsuarioByActivatedRequest $request) {
        $estado = UsuarioStatus::ACTIVATED;
        $usuario = $this->usuarioRepository->find($request->getUsuarioId());
        $usuario->estado = $estado;
        $usuario->guia_o_supervisor_id = $request->getGuiaOSupervisorId();
        $usuario->password = $request->getPassword();
        $usuario->validation_token = null;
        $usuario->fecha_registro = new DateTime();
        $usuario = $this->usuarioRepository->update($usuario);
        return new UpdateUsuarioByActivatedResponse(
            $usuario->email,
            $usuario->nombre,
            $usuario->password,
            $usuario->rol->nombre
        );
    }

}
