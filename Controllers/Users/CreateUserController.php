<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Model/EmailDestinationModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetRoles/Dto/GetRolesResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Controllers/Users/LoginController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/ValidatePermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Domain/Constants/RolTypeEnum.php";
require_once '../../DependencyInjection.php';


class CreateUserController
{
    public function createUser(array $request){
        SessionUtility::startSession();
        try {
            DependencyInjection::getTransactionManager()->begin();
            $userLogin = @$_SESSION[ItemsInSessionEnum::USER_LOGIN];
            if ($userLogin->getRol() == RolTypeEnum::GUIA) {
                throw new ValidatePermissionException();
            }

            $rolesResponse = @$_SESSION[ItemsInSessionEnum::LIST_ROLES];
            if (!isset($rolesResponse) ) {
                $rolesResponse = DependencyInjection::getRolesServce()->getRoles();
                $_SESSION[ItemsInSessionEnum::LIST_ROLES] = $rolesResponse;
            }
            $roles = $rolesResponse->getRoles();

            $email = $_POST['email'];
            $password = Utility::generateGUID(2);
            $nombre = $_POST['nombre'];
            $rol_id = (int)$_POST['rol_id'];
            
            $rolSelected = array_filter($roles, function ($rol)  use ($rol_id) {
                return $rol->getId() == $rol_id;
            });

            $rolSelected = reset($rolSelected);

            if ($userLogin->getRol() === RolTypeEnum::SUPERVISOR 
                && $rolSelected->getNombre() === RolTypeEnum::SUPER_USUARIO) {
                throw new ValidatePermissionException();
            }

            if ($userLogin->getRol() === RolTypeEnum::SUPERVISOR 
                && $rolSelected->getNombre() === RolTypeEnum::SUPERVISOR) {
                throw new ValidatePermissionException();
            }
                
            $usuario_registro = $userLogin->getId();
            $createUserRequest = new CreateUserRequest(
                $email, $password, $nombre, $rol_id, $usuario_registro
            );
            
            $createUserUseCase = DependencyInjection::getCreateUserServce();
            $createUserResponse = $createUserUseCase->createUser($createUserRequest);
            $subjetMessage = "Usuario ".$createUserResponse->getRolNombre()." creado en Sistema de gestion de turnos para guias de Turismo";
            $bodyMessage = $this->generateBodyMessage($createUserResponse);
            $emailDestinationModel = new EmailDestinationModel(
                $createUserResponse->getUsuario()->getEmail(),
                $createUserResponse->getUsuario()->getNombre(),
                $subjetMessage,
                $bodyMessage
            );
            $emailServerService = DependencyInjection::getEmailSenderServce();
            $emailResponse = $emailServerService->send($emailDestinationModel);
            if(strstr($emailResponse,"No pudo ser enviada")) {
                throw new EmailSenderException($emailResponse);
            }
            $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] = $emailResponse;
            // $uri = "/Views/Users/index.php";
            // $url = UrlHelper::getUrl($uri);
            DependencyInjection::getTransactionManager()->commit();
            header("Location: ../../Views/Users/index.php?action=create");
            exit();
        }
        catch (Exception $e) {
                DependencyInjection::getTransactionManager()->rollback();
                $errorMessage = 'Error al Crear Usuario: ' . $e->getMessage();
                $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $errorMessage;
                header("Location: ../../Views/Users/index.php?action=create");
                exit();
        }
    }

    private function showCreateForm($error = null, $roles = [])
    {
        $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $error;
        $uri = "/Views/Users/create.php";
        $url = UrlHelper::getUrl($uri);
        header("Location: $url");
    }

    private function generateBodyMessage(CreateUserResponse $response)
    {
        $nombre = $response->getUsuario()->getNombre();
        $email = $response->getUsuario()->getEmail();
        $rol = $response->getRolNombre();
        $password = $response->getUsuario()->getPassword();
        $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $relative_url = '/guiastur/Views/Users/login.php';
        $url = $scheme . '://' . $host . $relative_url;
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
