<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Model/EmailDestinationModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRoles/Dto/GetRolesResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/Users/LoginController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Constants/RolTypeEnum.php";
require_once '../../DependencyInjection.php';


class CreateUserController
{
    public function handleRequest(array $request)
    {
        SessionUtility::startSession();
        $transacctionDb = DependencyInjection::getTransactionManager();
        try {
            $transacctionDb->begin();
            $userLogin = @$_SESSION[ItemsInSessionEnum::USER_LOGIN];
            if (!isset($userLogin)) {
                throw new InvalidPermissionException();
            }
            if ($userLogin->getRol() == RolTypeEnum::GUIA || $userLogin->getRol() == RolTypeEnum::USUARIO) {
                throw new InvalidRequestParameterException("Usted no tiene permisos para crear Usuarios");
            }

            $rolesResponse = @$_SESSION[ItemsInSessionEnum::LIST_ROLES];
            if (!isset($rolesResponse)) {
                $rolesResponse = DependencyInjection::getRolesServce()->getRoles();
                $_SESSION[ItemsInSessionEnum::LIST_ROLES] = $rolesResponse;
            }

            $roles = $rolesResponse->getRoles();

            $email = $_POST['email'];
            $password = Utility::generateGUID(2);
            $nombre = $_POST['nombre'];
            $rol_id = (int) $_POST['rol_id'];

            $rolSelected = array_filter($roles, function ($rol) use ($rol_id) {
                return $rol->getId() == $rol_id;
            });

            $rolSelected = reset($rolSelected);

            if (
                $userLogin->getRol() === RolTypeEnum::SUPERVISOR
                && $rolSelected->getNombre() === RolTypeEnum::SUPER_USUARIO
            ) {
                throw new InvalidRequestParameterException("Usted no tiene permisos para crear Super usuarios");
            }

            if (
                $userLogin->getRol() === RolTypeEnum::SUPERVISOR
                && $rolSelected->getNombre() === RolTypeEnum::SUPERVISOR
            ) {
                throw new InvalidRequestParameterException("Usted no tiene permisos para crear Supervisores");
            }

            $usuario_registro = $userLogin->getId();
            $createUserRequest = new CreateUserRequest(
                $email,
                $password,
                $nombre,
                $rol_id,
                $usuario_registro
            );

            $createUserUseCase = DependencyInjection::getCreateUserServce();
            $createUserResponse = $createUserUseCase->createUser($createUserRequest);

            $subjetMessage = "Usuario " . $createUserResponse->getRolNombre() . " creado en Sistema de gestion de turnos para guias de Turismo";
            $bodyMessage = $this->generateBodyMessage($createUserResponse);
            $emailDestinationModel = new EmailDestinationModel(
                $createUserResponse->getEmail(),
                $createUserResponse->getNombre(),
                $subjetMessage,
                $bodyMessage
            );
            $emailServerService = DependencyInjection::getEmailSenderServce();
            $emailResponse = $emailServerService->send($emailDestinationModel);
            if (strstr($emailResponse, "No pudo ser enviada")) {
                throw new EmailSenderException($emailResponse);
            }
            $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] = $emailResponse;
            $transacctionDb->commit();
            header("Location: ../../Views/Users/index.php?action=create");
            exit();
        } 
        catch (InvalidRequestParameterException $e) {
            $transacctionDb->rollback();
            $errorMessage =  $e->getMessage();
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $errorMessage;
            header("Location: ../../Views/Users/create.php");
            exit();
        }
        catch (DuplicateEntryException $e) {
            $transacctionDb->rollback();
            $errorMessage =  $e->getMessage();
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $errorMessage;
            header("Location: ../../Views/Users/create.php");
            exit();
        }
        catch (Exception $e) {
            $transacctionDb->rollback();
            session_destroy();
            SessionUtility::startSession();
            $errorMessage =  $e->getMessage();
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $errorMessage;
            header("Location: ../../Views/Users/index.php?action=create");
            exit();
        }
    }

    private function generateBodyMessage(CreateUserResponse $response)
    {
        $nombre = $response->getNombre();
        $email = $response->getEmail();
        $rol = $response->getRolNombre();
        $password = $response->getPassword();
        $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $uri = "/Views/Users/index.php";
        $parameters = "?action=activate&token=" . $response->getValidationToken();
        $url = UrlHelper::getUrl($uri);
        $url .= $parameters;
        $template = "../../Views/Users/TemplateNotificacionNewUser.html";
        $htmlTemplate = file_get_contents($template);
        $htmlContent = str_replace(
            ['[[nombre]]', '[[email]]', '[[pass]]', '[[rol]]', '[[url]]'],
            [$nombre, $email, $password, $rol, $url],
            $htmlTemplate
        );
        return $htmlContent;
    }
}
