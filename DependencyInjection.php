<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/AtencionRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/BuqueRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/GuiaRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/SupervisorRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/RecaladaRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/TurnoRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/UsuarioRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/PaisRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/RolRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/ExternalServices/EmailSenderService.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateAtencionCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateBuqueCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateTurnoCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateUser/CreateUserGuiaCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateUser/CreateUserSupervisorCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/EndTurnoCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CancelTurnoCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateRecaladaCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/ReleaseTurnoCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/CreateUser/CreateUserCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Commands/UseTurnoCommandHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetAtencionesByRecaladaQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetBuqueByIdQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetRecaladasInThePortQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetTurnoByIdQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/LoginQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/ValidateAtencionQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetTurnosByAtencionQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetNextTurnoQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetUsuarioByIdQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetPaisesQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetRolesQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateAtencion/CreateAtencionUseCase.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateBuque/CreateBuqueUseCase.php";  // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateTurno/CreateTurnoUseCase.php";   // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/CreateUserGuiaUseCase.php";  // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/CreateUserSupervisorUseCase.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/EndTurno/EndTurnoUseCase.php";  // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetAtencionesByRecalada/GetAtencionesByRecaladaUseCase.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/CreateUserUseCase.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetBuqueById/GetBuqueByIdUseCase.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetNextTurno/GetNextTurnoUseCase.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRecaladasInThePort/GetRecaladasInThePortUseCase.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencionUseCase/GetTurnosByAtencionUseCase.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/LoginUseCase.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/ReleaseTurno/ReleaseTurnoUseCase.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/UseTurno/UseTurnoUseCase.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CancelTurno/CancelTurnoUseCase.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateRecalada/CreateRecaladaUseCase.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetPaises/GetPaisesService.php"; // ok
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRoles/GetRolesService.php"; // ok



class DependencyInjection
{

    public static function getCreateRecaladaServce(): ICreateRecaladaUseCase
    {
        $repositorio = new RecaladaRepository();
        $validateRecaladaQuery = new ValidateRecaladaQueryHandler($repositorio);
        $createRecaladaCommand = new CreateRecaladaCommandHandler($repositorio);
        return new CreateRecaladaUseCase($validateRecaladaQuery, $createRecaladaCommand);
    }


    public static function getCancelTurnoServce(): ICancelTurnoUseCase
    {
        $usuarioRepository = new UsuarioRepository();
        $turnoRepository = new TurnoRepository();
        $getTurnoByIdQuery = new GetTurnoByIdQueryHandler($turnoRepository);
        $getUsuarioByIdQuer = new GetUsuarioByIdQueryHandler($usuarioRepository);
        $cancelTurnoCommand = new CancelTurnoCommandHandler($turnoRepository);
        return new CancelTurnoUseCase($getTurnoByIdQuery, $getUsuarioByIdQuer, $cancelTurnoCommand);
    }

    public static function getUseTurnoServce(): IUseTurnoUseCase
    {
        $usuarioRepository = new UsuarioRepository();
        $turnoRepository = new TurnoRepository();
        $getNextTurnoQuery = new GetNextTurnoQueryHandler($turnoRepository);
        $useTurnoCommand = new UseTurnoCommandHandler($turnoRepository);
        $getUsuarioByIdQuery = new GetUsuarioByIdQueryHandler($usuarioRepository);
        return new UseTurnoUseCase($getUsuarioByIdQuery, $getNextTurnoQuery, $useTurnoCommand);
    }

    public static function getReleaseTurnoServce(): IReleaseTurnoUseCase
    {
        $usuarioRepository = new UsuarioRepository();
        $turnoRepository = new TurnoRepository();
        $getTurnoByIdQuery = new GetTurnoByIdQueryHandler($turnoRepository);
        $getUsuarioByIdQuery = new GetUsuarioByIdQueryHandler($usuarioRepository);
        $releaseTurnoCommand = new ReleaseTurnoCommandHandler($turnoRepository);
        return new ReleaseTurnoUseCase($getTurnoByIdQuery, $getUsuarioByIdQuery, $releaseTurnoCommand);
    }


    public static function getLoginServce(): ILoginUseCase
    {
        $repository = new UsuarioRepository();
        $loginQuery = new LoginQueryHandler($repository);
        return new LoginUseCase($loginQuery);
    }

    public static function GetTurnosByAtencionServce(): IGetTurnosByAtencionUseCase
    {
        $repository = new TurnoRepository();
        $getTurnosByAtencionQuery = new GetTurnosByAtencionQueryHandler($repository);
        return new GetTurnosByAtencionUseCase($getTurnosByAtencionQuery);
    }


    public static function getRecaladasInThePortServce(): IGetRecaladasInThePortUseCase
    {
        $repository = new RecaladaRepository();
        $getRecaladasInThePortQuery = new GetRecaladasInThePortQueryHandler($repository);
        return new GetRecaladasInThePortUseCase($getRecaladasInThePortQuery);
    }


    public static function getNextTurnoServce(): IGetNextTurnoUseCase
    {
        $repository = new TurnoRepository();
        $getNextTurnoQuery = new GetNextTurnoQueryHandler($repository);
        return new GetNextTurnoUseCase($getNextTurnoQuery);
    }

    public static function getBuqueByIdServce(): IGetBuqueByIdUseCase
    {
        $repository = new BuqueRepository();
        $etBuqueByIdQueryr = new GetBuqueByIdQueryHandler($repository);
        return new GetBuqueByIdUseCase($etBuqueByIdQueryr);
    }

    public static function getCreateUserServce(): ICreateUserUseCase
    {
        $repository = new UsuarioRepository();
        $createUserCommand = new CreateUserCommandHandler($repository);
        return new CreateUserUseCase($createUserCommand);
    }

    public static function getCreateAtencionServce(): ICreateAtencionUseCase
    {
        $atencionRepository = new AtencionRepository();
        $validateAtencionQuery = new ValidateAtencionQueryHandler($atencionRepository);
        $createAtencionCommand = new CreateAtencionCommandHandler($atencionRepository);
        return new CreateAtencionUseCase($validateAtencionQuery, $createAtencionCommand);
    }

    public static function getCreateBuqueServce(): ICreateBuqueUseCase
    {
        $buqueRepository = new BuqueRepository();
        $createBuqueCommand = new CreateBuqueCommandHandler($buqueRepository);
        return new CreateBuqueUseCase($createBuqueCommand);
    }

    public static function getCreateTurnoServce(): ICreateTurnoUseCase
    {
        $turnoRepository = new TurnoRepository();
        $getTurnosByAtencionQuery = new GetTurnosByAtencionQueryHandler($turnoRepository);
        $createTurnoCommand = new CreateTurnoCommandHandler($turnoRepository);
        return new CreateTurnoUseCase($getTurnosByAtencionQuery, $createTurnoCommand);
    }

    public static function getCreateUserGuiaServce(): ICreateUserGuiaUseCase
    {
        $guiaRepository = new GuiaRepository();
        $createUserGuiaCommand = new CreateUserGuiaCommandHandler($guiaRepository);
        return new CreateUserGuiaUseCase($createUserGuiaCommand);
    }

    public static function getCreateUserSupervisorServce(): ICreateUserSupervisorUseCase
    {
        $supervisorRepository = new SupervisorRepository();
        $createUserSupervisorCommand = new CreateUserSupervisorCommandHandler($supervisorRepository);
        return new CreateUserSupervisorUseCase($createUserSupervisorCommand);
    }

    public static function getEndTurnoServce(): IEndTurnoUseCase
    {
        $turnoRepository = new TurnoRepository();
        $usuarioRepository = new UsuarioRepository();
        $getTurnoByIdQuery = new GetTurnoByIdQueryHandler($turnoRepository);
        $getUsuarioByIdQuery = new GetUsuarioByIdQueryHandler($usuarioRepository);
        $endTurnoCommand = new EndTurnoCommandHandler($turnoRepository);
        return new EndTurnoUseCase($getTurnoByIdQuery, $getUsuarioByIdQuery, $endTurnoCommand);
    }

    public static function getAtencionesByRecaladaServce(): IGetAtencionesByRecaladaUseCase
    {
        $repository = new AtencionRepository();
        $getAtencionesByRecaladasQuery = new GetAtencionesByRecaladaQueryHandler($repository);
        return new GetAtencionesByRecaladaUseCase($getAtencionesByRecaladasQuery);
    }

    public static function getPaisesServce(): IGetPaisesService
    {
        $paisRespository = new PaisRepository();
        $getPaisesQuery = new GetPaisesQueryHandler($paisRespository);
        return new GetPaisesService($getPaisesQuery);
    }

    public static function getRolesServce(): IGetRolesService
    {
        $rolRespository = new RolRepository();
        $getRolesQuery = new GetRolesQueryHandler($rolRespository);
        return new GetRolesService($getRolesQuery);
    }

    public static function getEmailSenderServce(): IEmailSenderService
    {
        return new EmailSenderService();
    }
}





