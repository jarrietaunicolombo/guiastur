<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetUsusarioByToken/Dto/GetUsuarioByTokenRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetUsusarioByToken/Dto/GetUsuarioByTokenResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Queries/IGetUserByTokenQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Repositories/IUsuarioRepository.php";

class GetUserByTokenQueryHandler implements IGetUserByTokenQuery
{
    private $userRepository;

    public function __construct(IUsuarioRepository $usuarioRepository)
    {
        $this->userRepository = $usuarioRepository;
    }
    public function handler(GetUsuarioByTokenRequest $request): GetUsuarioByTokenResponse
    {
        $usuario = $this->userRepository->find($request->getId());
        if ($usuario->validation_token === null) {
            throw new InvalidActivationException("Cuenta previamente activada, revise su correo");
        }
        return new GetUsuarioByTokenResponse(
            $usuario->id,
            $usuario->email,
            $usuario->password,
            $usuario->nombre,
            $usuario->rol_id,
            $usuario->rol->nombre,
            $usuario->validation_token,
            $usuario->estado
        );
    }
}