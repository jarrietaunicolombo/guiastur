<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetSupervisor/Dto/GetSupervisorResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Queries/IGetSupervisoresQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Repositories/ISupervisorRepository.php";


class GetSupervisoresQueryHandler implements IGetSupervisoresQuery{
    private $supervisorRepository;

    public function __construct(ISupervisorRepository $supervisorRepository){
        $this->supervisorRepository = $supervisorRepository;
    }

    public function handler() : array{
        $supervisoresEntities = $this->supervisorRepository->findAll();
       $supervisoresDto = [];
       foreach($supervisoresEntities as $supevisorEntity){
            $supervisoresDto[] =   new GetSupervisorResponse(
                new UsuarioResponseDto(
                    $supevisorEntity->usuario->id,
                    $supevisorEntity->usuario->nombre,
                    $supevisorEntity->usuario->email,
                    $supevisorEntity->usuario->estado,
                    $supevisorEntity->usuario->guia_o_supervisor_id,
                    $supevisorEntity->usuario->validation_token,
                    new DateTime($supevisorEntity->usuario->fecha_registro),
                    $supevisorEntity->usuario->usuario_registro,
                    $supevisorEntity->usuario->rol->id,
                    $supevisorEntity->usuario->rol->nombre
                ),
                new SupervisorResponseDto(
                    $supevisorEntity->cedula,
                    $supevisorEntity->rnt,
                    $supevisorEntity->nombres,
                    $supevisorEntity->apellidos,
                    $supevisorEntity->genero,
                    new DateTime($supevisorEntity->fecha_nacimiento),
                    $supevisorEntity->telefono,
                    $supevisorEntity->foto,
                    $supevisorEntity->observaciones,
                    $supevisorEntity->usuario_registro,
                    new DateTime($supevisorEntity->fecha_registro)
                )            
            );
       }
       return $supervisoresDto;
       
    }
}