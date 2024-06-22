<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateUserCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IUsuarioRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Entities/Usuario.php";

class CreateUserCommandHandler implements ICreateUserCommand {
    private $usuarioRepository;

    public function __construct(IUsuarioRepository $usuarioRepository) {
        $this->usuarioRepository = $usuarioRepository;
    }

    public function handler(CreateUserRequest $request) : CreateUserResponse {
        $user = new Usuario();
        $user->email = $request->getEmail();
        $user->nombre = $request->getNombre();
        $user->estado = $request->getEstado();
        $user->password = $request->getPassword();
        $user->rol_id = $request->getRolId();
        $user->fecha_registro = $request->getFechaRegistro();
        $user->usuario_registro = $request->getUsuarioRegistro();
        $user = $this->usuarioRepository->create($user);
        return  new CreateUserResponse(
                                    $user->id
                                    , $user->validation_token
                                    , $user->rol->nombre
                                    , $request);
    }
}