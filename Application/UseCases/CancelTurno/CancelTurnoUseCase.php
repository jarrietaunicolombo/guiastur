<?php
require_once __DIR__."/Dto/CancelTurnoRequest.php";
require_once __DIR__."/Dto/CancelTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnoById/Dto/GetTurnoByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnoById/Dto/GetTurnoByIdResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetUsuarioById/Dto/GetUsuarioByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetUsuarioById/Dto/GetUsuarioByIdResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetTurnoByIdQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetUsuarioByIdQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICancelTurnoCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ICancelTurnoUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/ValidateCancelTurnoException.php";

class CancelTurnoUseCase implements ICancelTurnoUseCase{
    private $getTurnoByIdQuery;
    private $getUsuarioByIdQuery;
    private $endTurnoCommand;

    public function __construct(IGetTurnoByIdQuery $getTurnoByIdQuery
                                , IGetUsuarioByIdQuery $getUsuarioByIdQuery
                                , ICancelTurnoCommand $endTurnoCommand) 
    {
        $this->getTurnoByIdQuery = $getTurnoByIdQuery;
        $this->getUsuarioByIdQuery = $getUsuarioByIdQuery;
        $this->endTurnoCommand = $endTurnoCommand;
    }

    public function cancelTurno(CancelTurnoRequest $request): CancelTurnoResponse{
        $getTurnoByIdRequest = new GetTurnoByIdRequest($request->getTurnoId());
        $getTurnoByIdResponse = $this->getTurnoByIdQuery->handler($getTurnoByIdRequest);
        if($getTurnoByIdResponse->getEstado() !==  TurnoStatusEnum::CREATED || 
            $getTurnoByIdResponse->getEstado() !==  TurnoStatusEnum::INUSE){
            throw new ValidateCancelTurnoException("No se puede finalizar el Turno #: ".$getTurnoByIdResponse->getNumero() . ", Atencion Id: ".$getTurnoByIdResponse->getAtencion()->getId(). " El turno no está Creado, ni esta en Uso");
        }
        
        $usuarioByIdRequest = new GetUsuarioByIdRequest($request->getUsuarioCancelId());
        $usuarioByIdResponse = $this->getUsuarioByIdQuery->handler($usuarioByIdRequest);
        if($usuarioByIdResponse->getRolNombre() !== RolTypeEnum::SUPER_USUARIO 
            && $usuarioByIdResponse->getRolNombre() !== RolTypeEnum::SUPERVISOR
            && $usuarioByIdResponse->getId() != $getTurnoByIdResponse->getGuia()->getUsuarioId())
        {
            throw new ValidateCancelTurnoException("No tiene permisos para terminar el turno ".$getTurnoByIdResponse->getNumero() ." del Guia ". $getTurnoByIdResponse->getGuia()->getNombre());
        }  

        return $this->endTurnoCommand->handler($request);
    }
}
         
