<?php
require_once __DIR__ . "/Dto/FinishTurnoRequest.php";
require_once __DIR__ . "/Dto/FinishTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetTurnoById/Dto/GetTurnoByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetTurnoById/Dto/GetTurnoByIdResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetUsuarioById/Dto/GetUsuarioByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetUsuarioById/Dto/GetUsuarioByIdResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Queries/IGetTurnoByIdQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Queries/IGetUsuarioByIdQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Commands/IFinishTurnoCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/UseCases/IFinishTurnoUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidFinishTurnoException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/TurnoStatusEnum.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/RolTypeEnum.php";


class FinishTurnoUseCase implements IFinishTurnoUseCase {
    private $getTurnoByIdQuery;
    private $getUsuarioByIdQuery;
    private $endTurnoCommand;

    public function __construct(IGetTurnoByIdQuery $getTurnoByIdQuery
                                , IGetUsuarioByIdQuery $getUsuarioByIdQuery
                                , IFinishTurnoCommand $endTurnoCommand) 
    {
        $this->getTurnoByIdQuery = $getTurnoByIdQuery;
        $this->getUsuarioByIdQuery = $getUsuarioByIdQuery;
        $this->endTurnoCommand = $endTurnoCommand;
    }

    public function finishTurno(FinishTurnoRequest $request): FinishTurnoResponse{
        $getTurnoByIdRequest = new GetTurnoByIdRequest($request->getTurnoId());
        $getTurnoByIdResponse = $this->getTurnoByIdQuery->handler($getTurnoByIdRequest);
        if($getTurnoByIdResponse->getEstado() !==  TurnoStatusEnum::RELEASE){
            throw new InvalidFinishTurnoException("El Turno #: ".$getTurnoByIdResponse->getNumero() . " de la Atencion Id: ".$getTurnoByIdResponse->getAtencion()->getId(). " no fue liberado");
        }    
        
        $usuarioByIdRequest = new GetUsuarioByIdRequest($request->getUsuarioIdUso());
        $usuarioByIdResponse = $this->getUsuarioByIdQuery->handler($usuarioByIdRequest);
        if($usuarioByIdResponse->getRolNombre() !== RolTypeEnum::SUPER_USUARIO 
            && $usuarioByIdResponse->getRolNombre() !== RolTypeEnum::SUPERVISOR
            && $usuarioByIdResponse->getId() != $getTurnoByIdResponse->getGuia()->getUsuarioId())
        {
            throw new InvalidFinishTurnoException("No tiene permisos para terminar el turno ".$getTurnoByIdResponse->getNumero() ." del Guia ". $getTurnoByIdResponse->getGuia()->getNombre());
        }  

        return $this->endTurnoCommand->handler($request);
    }
}
         
