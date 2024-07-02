<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetUsuarioById/Dto/GetUsuarioByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetUsuarioById/Dto/GetUsuarioByIdResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetUsuarioByIdQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IUsuarioRepository.php";


class GetUsuarioByIdQueryHandler implements IGetUsuarioByIdQuery{
    private $usuarioRepository;

    public function __construct(IUsuarioRepository $usuarioRepository){
        $this->usuarioRepository = $usuarioRepository;
    }

    public function handler(GetUsuarioByIdRequest $request): GetUsuarioByIdResponse{
        $usuario = $this->usuarioRepository->find($request->getUsuarioId());
        return new GetUsuarioByIdResponse(
            $usuario->id,
            $usuario->nombre,
            $usuario->email,
            $usuario->estado,
            $usuario->guia_o_supervisor_id,
            $usuario->validation_token,
            $usuario->fecha_registro,
            $usuario->usuario_registro,
            $usuario->rol->id,
            $usuario->rol->nombre
        );
    }
}