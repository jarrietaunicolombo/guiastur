<?php
require_once __DIR__ . "/ClassLoader.php";
class DependencyInjection
{

    public static function getCreateRecaladaServce(): ICreateRecaladaUseCase
    {
        ClassLoader::loadClass("RecaladaRepository");
        ClassLoader::loadClass("ValidateRecaladaQueryHandler");
        ClassLoader::loadClass("CreateRecaladaCommandHandler");
        ClassLoader::loadClass("CreateRecaladaUseCase");
        $repositorio = new RecaladaRepository();
        $validateRecaladaQuery = new ValidateRecaladaQueryHandler($repositorio);
        $createRecaladaCommand = new CreateRecaladaCommandHandler($repositorio);
        return new CreateRecaladaUseCase($validateRecaladaQuery, $createRecaladaCommand);
    }


    public static function getCancelTurnoServce(): ICancelTurnoUseCase
    {
        ClassLoader::loadClass("UsuarioRepository");
        ClassLoader::loadClass("TurnoRepository");
        ClassLoader::loadClass("GetTurnoByIdQueryHandler");
        ClassLoader::loadClass("GetUsuarioByIdQueryHandler");
        ClassLoader::loadClass("CancelTurnoCommandHandler");
        ClassLoader::loadClass("CancelTurnoUseCase");
        $usuarioRepository = new UsuarioRepository();
        $turnoRepository = new TurnoRepository();
        $getTurnoByIdQuery = new GetTurnoByIdQueryHandler($turnoRepository);
        $getUsuarioByIdQuer = new GetUsuarioByIdQueryHandler($usuarioRepository);
        $cancelTurnoCommand = new CancelTurnoCommandHandler($turnoRepository);
        return new CancelTurnoUseCase($getTurnoByIdQuery, $getUsuarioByIdQuer, $cancelTurnoCommand);
    }

    public static function getUseTurnoServce(): IUseTurnoUseCase
    {
        ClassLoader::loadClass("UsuarioRepository");
        ClassLoader::loadClass("TurnoRepository");
        ClassLoader::loadClass("GetNextTurnoQueryHandler");
        ClassLoader::loadClass("UseTurnoCommandHandler");
        ClassLoader::loadClass("GetUsuarioByIdQueryHandler");
        ClassLoader::loadClass("UseTurnoUseCase");
        $usuarioRepository = new UsuarioRepository();
        $turnoRepository = new TurnoRepository();
        $getNextTurnoQuery = new GetNextTurnoQueryHandler($turnoRepository);
        $useTurnoCommand = new UseTurnoCommandHandler($turnoRepository);
        $getUsuarioByIdQuery = new GetUsuarioByIdQueryHandler($usuarioRepository);
        return new UseTurnoUseCase($getUsuarioByIdQuery, $getNextTurnoQuery, $useTurnoCommand);
    }

    public static function getReleaseTurnoServce(): IReleaseTurnoUseCase
    {
        ClassLoader::loadClass("UsuarioRepository");
        ClassLoader::loadClass("TurnoRepository");
        ClassLoader::loadClass("GetTurnoByIdQueryHandler");
        ClassLoader::loadClass("GetUsuarioByIdQueryHandler");
        ClassLoader::loadClass("ReleaseTurnoCommandHandler");
        ClassLoader::loadClass("ReleaseTurnoUseCase");
        $usuarioRepository = new UsuarioRepository();
        $turnoRepository = new TurnoRepository();
        $getTurnoByIdQuery = new GetTurnoByIdQueryHandler($turnoRepository);
        $getUsuarioByIdQuery = new GetUsuarioByIdQueryHandler($usuarioRepository);
        $releaseTurnoCommand = new ReleaseTurnoCommandHandler($turnoRepository);
        return new ReleaseTurnoUseCase($getTurnoByIdQuery, $getUsuarioByIdQuery, $releaseTurnoCommand);
    }


    public static function getLoginServce(): ILoginUseCase
    {
        ClassLoader::loadClass("UsuarioRepository");
        ClassLoader::loadClass("LoginQueryHandler");
        ClassLoader::loadClass("LoginUseCase");
        $repository = new UsuarioRepository();
        $loginQuery = new LoginQueryHandler($repository);
        return new LoginUseCase($loginQuery);
    }

    public static function GetTurnosByAtencionServce(): IGetTurnosByAtencionUseCase
    {
        ClassLoader::loadClass("TurnoRepository");
        ClassLoader::loadClass("GetTurnosByAtencionQueryHandler");
        ClassLoader::loadClass("GetTurnosByAtencionUseCase");
        $repository = new TurnoRepository();
        $getTurnosByAtencionQuery = new GetTurnosByAtencionQueryHandler($repository);
        return new GetTurnosByAtencionUseCase($getTurnosByAtencionQuery);
    }


    public static function getRecaladasInThePortServce(): IGetRecaladasInThePortUseCase
    {
        ClassLoader::loadClass("RecaladaRepository");
        ClassLoader::loadClass("GetRecaladasInThePortQueryHandler");
        ClassLoader::loadClass("GetRecaladasInThePortUseCase");
        $repository = new RecaladaRepository();
        $getRecaladasInThePortQuery = new GetRecaladasInThePortQueryHandler($repository);
        return new GetRecaladasInThePortUseCase($getRecaladasInThePortQuery);
    }


    public static function getNextTurnoServce(): IGetNextTurnoUseCase
    {
        ClassLoader::loadClass("TurnoRepository");
        ClassLoader::loadClass("GetNextTurnoQueryHandler");
        ClassLoader::loadClass("GetNextTurnoUseCase");
        $repository = new TurnoRepository();
        $getNextTurnoQuery = new GetNextTurnoQueryHandler($repository);
        return new GetNextTurnoUseCase($getNextTurnoQuery);
    }

    public static function getBuqueByIdServce(): IGetBuqueByIdUseCase
    {
        ClassLoader::loadClass("BuqueRepository");
        ClassLoader::loadClass("GetBuqueByIdQueryHandler");
        ClassLoader::loadClass("GetBuqueByIdUseCase");
        $repository = new BuqueRepository();
        $etBuqueByIdQueryr = new GetBuqueByIdQueryHandler($repository);
        return new GetBuqueByIdUseCase($etBuqueByIdQueryr);
    }

    public static function getCreateUserServce(): ICreateUserUseCase
    {
        ClassLoader::loadClass("UsuarioRepository");
        ClassLoader::loadClass("CreateUserCommandHandler");
        ClassLoader::loadClass("CreateUserUseCase");
        $repository = new UsuarioRepository();
        $createUserCommand = new CreateUserCommandHandler($repository);
        return new CreateUserUseCase($createUserCommand);
    }

    public static function getCreateAtencionServce(): ICreateAtencionUseCase
    {
        ClassLoader::loadClass("AtencionRepository");
        ClassLoader::loadClass("ValidateAtencionQueryHandler");
        ClassLoader::loadClass("CreateAtencionCommandHandler");
        ClassLoader::loadClass("CreateAtencionUseCase");
        $atencionRepository = new AtencionRepository();
        $validateAtencionQuery = new ValidateAtencionQueryHandler($atencionRepository);
        $createAtencionCommand = new CreateAtencionCommandHandler($atencionRepository);
        return new CreateAtencionUseCase($validateAtencionQuery, $createAtencionCommand);
    }

    public static function getCreateBuqueServce(): ICreateBuqueUseCase
    {
        ClassLoader::loadClass("BuqueRepository");
        ClassLoader::loadClass("CreateBuqueCommandHandler");
        ClassLoader::loadClass("CreateBuqueUseCase");
        $buqueRepository = new BuqueRepository();
        $createBuqueCommand = new CreateBuqueCommandHandler($buqueRepository);
        return new CreateBuqueUseCase($createBuqueCommand);
    }

    public static function getCreateTurnoServce(): ICreateTurnoUseCase
    {
        ClassLoader::loadClass("TurnoRepository");
        ClassLoader::loadClass("GetTurnosByAtencionQueryHandler");
        ClassLoader::loadClass("CreateTurnoCommandHandler");
        ClassLoader::loadClass("CreateTurnoUseCase");
        $turnoRepository = new TurnoRepository();
        $getTurnosByAtencionQuery = new GetTurnosByAtencionQueryHandler($turnoRepository);
        $createTurnoCommand = new CreateTurnoCommandHandler($turnoRepository);
        return new CreateTurnoUseCase($getTurnosByAtencionQuery, $createTurnoCommand);
    }

    public static function getCreateUserGuiaServce(): ICreateUserUseCase
    {
        ClassLoader::loadClass("GuiaRepository");
        ClassLoader::loadClass("CreateUserGuiaCommandHandler");
        ClassLoader::loadClass("CreateUserGuiaUseCase");
        $guiaRepository = new GuiaRepository();
        $createUserGuiaCommand = new CreateUserGuiaCommandHandler($guiaRepository);
        return new CreateUserGuiaUseCase($createUserGuiaCommand);
    }

    public static function getCreateUserSupervisorServce(): ICreateUserUseCase
    {
        ClassLoader::loadClass("SupervisorRepository");
        ClassLoader::loadClass("CreateUserSupervisorCommandHandler");
        ClassLoader::loadClass("CreateUserSupervisorUseCase");
        $supervisorRepository = new SupervisorRepository();
        $createUserSupervisorCommand = new CreateUserSupervisorCommandHandler($supervisorRepository);
        return new CreateUserSupervisorUseCase($createUserSupervisorCommand);
    }

    public static function getEndTurnoServce(): IEndTurnoUseCase
    {
        ClassLoader::loadClass("TurnoRepository");
        ClassLoader::loadClass("UsuarioRepository");
        ClassLoader::loadClass("GetTurnoByIdQueryHandler");
        ClassLoader::loadClass("GetUsuarioByIdQueryHandler");
        ClassLoader::loadClass("EndTurnoCommandHandler");
        ClassLoader::loadClass("EndTurnoCommandHandler");
        $turnoRepository = new TurnoRepository();
        $usuarioRepository = new UsuarioRepository();
        $getTurnoByIdQuery = new GetTurnoByIdQueryHandler($turnoRepository);
        $getUsuarioByIdQuery = new GetUsuarioByIdQueryHandler($usuarioRepository);
        $endTurnoCommand = new EndTurnoCommandHandler($turnoRepository);
        return new EndTurnoUseCase($getTurnoByIdQuery, $getUsuarioByIdQuery, $endTurnoCommand);
    }

    public static function getAtencionesByRecaladaServce(): IGetAtencionesByRecaladaUseCase
    {
        ClassLoader::loadClass("AtencionRepository");
        ClassLoader::loadClass("GetAtencionesByRecaladaQueryHandler");
        ClassLoader::loadClass("GetAtencionesByRecaladaUseCase");
        $repository = new AtencionRepository();
        $getAtencionesByRecaladasQuery = new GetAtencionesByRecaladaQueryHandler($repository);
        return new GetAtencionesByRecaladaUseCase($getAtencionesByRecaladasQuery);
    }

    public static function getPaisesServce(): IGetPaisesService
    {
        ClassLoader::loadClass("PaisRepository");
        ClassLoader::loadClass("GetPaisesQueryHandler");
        ClassLoader::loadClass("GetPaisesService");
        $paisRespository = new PaisRepository();
        $getPaisesQuery = new GetPaisesQueryHandler($paisRespository);
        return new GetPaisesService($getPaisesQuery);
    }

    public static function getRolesServce(): IGetRolesService
    {
        ClassLoader::loadClass("RolRepository");
        ClassLoader::loadClass("GetRolesQueryHandler");
        ClassLoader::loadClass("GetRolesService");
        $rolRespository = new RolRepository();
        $getRolesQuery = new GetRolesQueryHandler($rolRespository);
        return new GetRolesService($getRolesQuery);
    }

    public static function getEmailSenderServce(): IEmailSenderService
    {
        ClassLoader::loadClass("EmailSenderService");
        return new EmailSenderService();
    }

    public static function getTransactionManager(): ITransactionManager
    {
        ClassLoader::loadClass("TransactionManager");
        return new TransactionManager();
    }

    public static function getUsuarioByTokenQuery(): IGetUserByTokenQuery
    {
        ClassLoader::loadClass("UsuarioRepository");
        ClassLoader::loadClass("GetUserByTokenQueryHandler");
        $repository = new UsuarioRepository();
        return new GetUserByTokenQueryHandler($repository);
    }

    public static function getUpdateUsuarioByActivatedCommand(): IUpdateUsuarioByActivatedCommand
    {
        ClassLoader::loadClass("UsuarioRepository");
        ClassLoader::loadClass("UpdateUsuarioByActivatedCommandHandler");
        $repository = new UsuarioRepository();
        return new UpdateUsuarioByActivatedCommandHandler($repository);
    }

}






