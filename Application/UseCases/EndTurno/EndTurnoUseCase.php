<?php
require_once __DIR__ . "/Dto/EndTurnoRequest.php";
require_once __DIR__ . "/Dto/EndTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnoById/Dto/GetTurnoByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnoById/Dto/GetTurnoByIdResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetUsuarioById/Dto/GetUsuarioByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetUsuarioById/Dto/GetUsuarioByIdResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetTurnoByIdQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetUsuarioByIdQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/IEndTurnoCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/IEndTurnoUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/ValidateEndTurnoException.php";

class EndTurnoUseCase implements IEndTurnoUseCase {
    private $getTurnoByIdQuery;
    private $getUsuarioByIdQuery;
    private $endTurnoCommand;

    public function __construct(IGetTurnoByIdQuery $getTurnoByIdQuery
                                , IGetUsuarioByIdQuery $getUsuarioByIdQuery
                                , IEndTurnoCommand $endTurnoCommand) 
    {
        $this->getTurnoByIdQuery = $getTurnoByIdQuery;
        $this->getUsuarioByIdQuery = $getUsuarioByIdQuery;
        $this->endTurnoCommand = $endTurnoCommand;
    }

    public function endTurno(EndTurnoRequest $request): EndTurnoResponse{
        $getTurnoByIdRequest = new GetTurnoByIdRequest($request->getTurnoId());
        $getTurnoByIdResponse = $this->getTurnoByIdQuery->handler($getTurnoByIdRequest);
        if($getTurnoByIdResponse->getEstado() !==  "Liberado"){
            throw new ValidateEndTurnoException("No se puede finalizar el Turno #: ".$getTurnoByIdResponse->getNumero() . ", Atencion Id: ".$getTurnoByIdResponse->getAtencion()->getId(). " El turno no está liberado");
        }    
        
        $usuarioByIdRequest = new GetUsuarioByIdRequest($request->getUsuarioIdUso());
        $usuarioByIdResponse = $this->getUsuarioByIdQuery->handler($usuarioByIdRequest);
        if($usuarioByIdResponse->getRolNombre() !== "Super Usuario" 
            && $usuarioByIdResponse->getRolNombre() !== "Supervisor" 
            && $usuarioByIdResponse->getId() != $getTurnoByIdResponse->getGuia()->getUsuarioId())
        {
            throw new ValidateEndTurnoException("No tiene permisos para terminar el turno ".$getTurnoByIdResponse->getNumero() ." del Guia ". $getTurnoByIdResponse->getGuia()->getNombre());
        }  

        return $this->endTurnoCommand->handler($request);
    }
}
         
