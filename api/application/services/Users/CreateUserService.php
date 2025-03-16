<?php

namespace Api\Services\Users;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Actions/Commands/CreateUser/CreateUserCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Repositories/IUsuarioRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/UsuarioRepository.php";

class CreateUserService {
    private $createUserCommandHandler;

    public function __construct(\IUsuarioRepository $usuarioRepository)
    {
        $this->createUserCommandHandler = new \CreateUserCommandHandler($usuarioRepository);
    }

    public function createUser($email, $password, $nombre, $rol_id, $creatorId): \CreateUserResponse
    {
        $createUserRequest = new \CreateUserRequest($email, $password, $nombre, $rol_id, $creatorId);
        return $this->createUserCommandHandler->handler($createUserRequest);
    }
}
