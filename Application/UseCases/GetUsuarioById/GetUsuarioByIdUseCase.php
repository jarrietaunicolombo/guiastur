<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetUsuarioById/Dto/GetUsuarioByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetUsuarioById/Dto/GetUsuarioByIdResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/IGetUsuarioByIdUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetUsuarioByIdQuery.php";

class GetUsuarioByIdUseCase implements IGetUsuarioByIdUseCase {

    private $getUsuarioByIdQuery;

    public function __construct(iGetUsuarioByIdQuery $getUsuarioByIdQuery) {
        $this->getUsuarioByIdQuery = $getUsuarioByIdQuery;
    }

    public function getUsuarioById(GetUsuarioByIdRequest $request): GetUsuarioByIdResponse{
       return $this->getUsuarioByIdQuery->handler($request);
    }
}
