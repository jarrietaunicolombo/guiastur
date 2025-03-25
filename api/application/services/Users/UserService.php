<?php

namespace Api\Services;

use Usuario;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Usuario.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/domain/repositories/UserMobileRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/RolTypeEnum.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidPermissionException.php";

class UserService
{

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new \UserMobileRepository();
    }

    public function getUsuario($usuario_id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $usuarios = Usuario::find_by_sql($sql, [$usuario_id]);
        return $usuarios ? $usuarios[0] : null;
    }

    public function getUsuarioRol($rol_id)
    {
        $sql = "SELECT * FROM Rols WHERE id = ?";
        $roles = Usuario::find_by_sql($sql, [$rol_id]);
        return $roles ? $roles[0] : null;
    }

    public function createUser($email, $password, $nombre, $rol_id, $creatorId)
    {
        $createUserRequest = new \CreateUserRequest(
            $email,
            $password,
            $nombre,
            $rol_id,
            $creatorId
        );

        $createUserUseCase = \DependencyInjection::getCreateUserServce();
        return $createUserUseCase->createUser($createUserRequest);
    }

    public function getUserById(int $userId)
    {
        return $this->userRepository->findById($userId);
    }
}
