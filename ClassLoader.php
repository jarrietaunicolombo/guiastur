<?php
class ClassLoader
{
    private static $classMap = [
        // Infrastructure Database
        'TransactionManager' => 'Infrastructure/Database/TransactionManager.php',
        // Infrastructure Repositories
        'AtencionRepository' => 'Infrastructure/Repositories/AtencionRepository.php',
        'BuqueRepository' => 'Infrastructure/Repositories/BuqueRepository.php',
        'GuiaRepository' => 'Infrastructure/Repositories/GuiaRepository.php',
        'SupervisorRepository' => 'Infrastructure/Repositories/SupervisorRepository.php',
        'RecaladaRepository' => 'Infrastructure/Repositories/RecaladaRepository.php',
        'TurnoRepository' => 'Infrastructure/Repositories/TurnoRepository.php',
        'UsuarioRepository' => 'Infrastructure/Repositories/UsuarioRepository.php',
        'PaisRepository' => 'Infrastructure/Repositories/PaisRepository.php',
        'RolRepository' => 'Infrastructure/Repositories/RolRepository.php',

        // External Services
        'EmailSenderService' => 'Infrastructure/ExternalServices/EmailSenderService.php',

        // Application Commands
        'CreateAtencionCommandHandler' => 'Application/Actions/Commands/CreateAtencionCommandHandler.php',
        'CreateBuqueCommandHandler' => 'Application/Actions/Commands/CreateBuqueCommandHandler.php',
        'CreateTurnoCommandHandler' => 'Application/Actions/Commands/CreateTurnoCommandHandler.php',
        'CreateUserGuiaCommandHandler' => 'Application/Actions/Commands/CreateUser/CreateUserGuiaCommandHandler.php',
        'CreateUserSupervisorCommandHandler' => 'Application/Actions/Commands/CreateUser/CreateUserSupervisorCommandHandler.php',
        'FinishTurnoCommandHandler' => 'Application/Actions/Commands/FinishTurnoCommandHandler.php',
        'CancelTurnoCommandHandler' => 'Application/Actions/Commands/CancelTurnoCommandHandler.php',
        'CreateRecaladaCommandHandler' => 'Application/Actions/Commands/CreateRecaladaCommandHandler.php',
        'ReleaseTurnoCommandHandler' => 'Application/Actions/Commands/ReleaseTurnoCommandHandler.php',
        'CreateUserCommandHandler' => 'Application/Actions/Commands/CreateUser/CreateUserCommandHandler.php',
        'UseTurnoCommandHandler' => 'Application/Actions/Commands/UseTurnoCommandHandler.php',
        'UpdateUsuarioByActivatedCommandHandler' => 'Application/Actions/Commands/UpdateUsuarioByActivatedCommandHandler.php',

        // Application Queries
        'GetAtencionesByRecaladaQueryHandler' => 'Application/Actions/Queries/GetAtencionesByRecaladaQueryHandler.php',
        'GetBuqueByIdQueryHandler' => 'Application/Actions/Queries/GetBuqueByIdQueryHandler.php',
        'GetRecaladasInThePortQueryHandler' => 'Application/Actions/Queries/GetRecaladasInThePortQueryHandler.php',
        'GetTurnoByIdQueryHandler' => 'Application/Actions/Queries/GetTurnoByIdQueryHandler.php',
        'LoginQueryHandler' => 'Application/Actions/Queries/LoginQueryHandler.php',
        'ValidateAtencionQueryHandler' => 'Application/Actions/Queries/ValidateAtencionQueryHandler.php',
        'GetTurnosByAtencionQueryHandler' => 'Application/Actions/Queries/GetTurnosByAtencionQueryHandler.php',
        'GetNextTurnoQueryHandler' => 'Application/Actions/Queries/GetNextTurnoQueryHandler.php',
        'GetUsuarioByIdQueryHandler' => 'Application/Actions/Queries/GetUsuarioByIdQueryHandler.php',
        'GetPaisesQueryHandler' => 'Application/Actions/Queries/GetPaisesQueryHandler.php',
        'GetRolesQueryHandler' => 'Application/Actions/Queries/GetRolesQueryHandler.php',
        'ValidateRecaladaQueryHandler' => 'Application/Actions/Queries/ValidateRecaladaQueryHandler.php',
        'GetUserByTokenQueryHandler' => 'Application/Actions/Queries/GetUserByTokenQueryHandler.php',
        'GetBuquesQueryHandler' => 'Application/Actions/Queries/GetBuquesQueryHandler.php',
        'GetRecaladasQueryHandler' => 'Application/Actions/Queries/GetRecaladasQueryHandler.php',
        'GetRecaladasByBuqueQueryHandler' => 'Application/Actions/Queries/GetRecaladasByBuqueQueryHandler.php',
        'GetNextAllTurnosByStatusQueryHandler' => 'Application/Actions/Queries/GetNextAllTurnosByStatusQueryHandler.php',
        'GetRecaladaByIdQueryHandler' => 'Application/Actions/Queries/GetRecaladaByIdQueryHandler.php',
        'GetSupervisoresQueryHandler' => 'Application/Actions/Queries/GetSupervisoresQueryHandler.php',
       
        // Application UseCases
        'CreateAtencionUseCase' => 'Application/UseCases/CreateAtencion/CreateAtencionUseCase.php',
        'CreateBuqueUseCase' => 'Application/UseCases/CreateBuque/CreateBuqueUseCase.php',
        'CreateTurnoUseCase' => 'Application/UseCases/CreateTurno/CreateTurnoUseCase.php',
        'CreateUserGuiaUseCase' => 'Application/UseCases/CreateUser/CreateUserGuiaUseCase.php',
        'CreateUserSupervisorUseCase' => 'Application/UseCases/CreateUser/CreateUserSupervisorUseCase.php',
        'FinishTurnoUseCase' => 'Application/UseCases/FinishTurno/FinishTurnoUseCase.php',
        'GetAtencionesByRecaladaUseCase' => 'Application/UseCases/GetAtencionesByRecalada/GetAtencionesByRecaladaUseCase.php',
        'CreateUserUseCase' => 'Application/UseCases/CreateUser/CreateUserUseCase.php',
        'GetBuqueByIdUseCase' => 'Application/UseCases/GetBuqueById/GetBuqueByIdUseCase.php',
        'GetNextTurnoUseCase' => 'Application/UseCases/GetNextTurno/GetNextTurnoUseCase.php',
        'GetRecaladasInThePortUseCase' => 'Application/UseCases/GetRecaladasInThePort/GetRecaladasInThePortUseCase.php',
        'GetTurnosByAtencionUseCase' => 'Application/UseCases/GetTurnosByAtencion/GetTurnosByAtencionUseCase.php',
        'LoginUseCase' => 'Application/UseCases/Login/LoginUseCase.php',
        'ReleaseTurnoUseCase' => 'Application/UseCases/ReleaseTurno/ReleaseTurnoUseCase.php',
        'UseTurnoUseCase' => 'Application/UseCases/UseTurno/UseTurnoUseCase.php',
        'CancelTurnoUseCase' => 'Application/UseCases/CancelTurno/CancelTurnoUseCase.php',
        'CreateRecaladaUseCase' => 'Application/UseCases/CreateRecalada/CreateRecaladaUseCase.php',
        'GetPaisesService' => 'Application/UseCases/GetPaises/GetPaisesService.php',
        'GetRolesService' => 'Application/UseCases/GetRoles/GetRolesService.php',
        'GetBuquesService' => 'Application/UseCases/GetBuques/GetBuquesService.php',
        'GetRecaladasService' => 'Application/UseCases/GetRecaladas/GetRecaladasService.php',
        'GetRecaladasByBuqueService' => 'Application/UseCases/GetRecaladasByBuque/GetRecaladasByBuqueService.php',
        'GetNextAllTurnosByStatusService' => 'Application/UseCases/GetNextTurno/GetNextAllTurnosByStatusService.php',
    ];

    public static function loadClass($className)
    {
        if (isset(self::$classMap[$className])) {
            $baseDir = $_SERVER["DOCUMENT_ROOT"] . "guiastur/";
            require_once $baseDir . self::$classMap[$className];
        } else {
            throw new Exception("Class $className not found in class map.");
        }
    }
}
