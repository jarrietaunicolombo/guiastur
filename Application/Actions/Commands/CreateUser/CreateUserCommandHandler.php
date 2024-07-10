<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateUserCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IUsuarioRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Usuario.php";

class CreateUserCommandHandler implements ICreateUserCommand
{
    private $usuarioRepository;

    public function __construct(IUsuarioRepository $usuarioRepository)
    {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function handler(CreateUserRequest $request): CreateUserResponse
    {
        $usuario = new Usuario();
        $usuario->email = $request->getEmail();
        $usuario->nombre = $request->getNombre();
        $usuario->estado = $request->getEstado();
        $usuario->password = $request->getPassword();
        $usuario->rol_id = $request->getRolId();
        $usuario->validation_token = Utility::generateGUID();
        $usuario->fecha_registro = $request->getFechaRegistro();
        $usuario->usuario_registro = $request->getUsuarioRegistro();
        $usuario = $this->usuarioRepository->create($usuario);
        return new CreateUserResponse(
            $usuario->id,
            $request->getEmail(),
            $request->getPassword(),
            $request->getNombre(),
            $request->getEstado(),
            $request->getRolId(),
            $usuario->rol->nombre,
            $usuario->validation_token,
            $request->getUsuarioRegistro(),
            $request->getFechaRegistro()
        );
    }
}