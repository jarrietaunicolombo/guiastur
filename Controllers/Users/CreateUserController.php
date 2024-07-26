<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Model/EmailDestinationModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetRoles/Dto/GetRolesResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/Users/LoginController.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/Login/Dto/LoginResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/RolTypeEnum.php";
require_once '../../DependencyInjection.php';


class CreateUserController
{
    public function handleRequest($request)
    {
        SessionUtility::startSession();
        $accion = @$request["action"];
        if ($accion === "create") {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->createUser($request);
            } else if ($_SERVER["REQUEST_METHOD"] === "GET") {
                $this->showFormCreateUser();
            } else {
                $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = "Accion Invalida";
                $errorResponse = ["error" => "Accion invalida"];
                echo json_encode($errorResponse);
                exit;
            }
        } else {
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = "Accion Invalida";
            $errorResponse = ["error" => "Accion invalida"];
            echo json_encode($errorResponse);
            exit;
        }
    }

    private function createUser(array $request)
    {
        SessionUtility::startSession();
        $transacctionDb = DependencyInjection::getTransactionManager();
        try {
            $transacctionDb->begin();
            $userLogin = @$_SESSION[ItemsInSessionEnum::USER_LOGIN];
            if (!isset($userLogin)) {
                throw new InvalidPermissionException("No tiene permisos para crear Usuario");
            }
            if ($userLogin->getRol() == RolTypeEnum::GUIA || $userLogin->getRol() == RolTypeEnum::USUARIO) {
                throw new InvalidRequestParameterException("Usted no tiene permisos para crear Usuarios");
            }

            $rolesResponse = (DependencyInjection::getRolesServce())->getRoles();
            if (!isset($rolesResponse) || @count($rolesResponse) == 0) {
                new Exception("No existen Roles disponibles");
            } else {
                $_SESSION[ItemsInSessionEnum::LIST_ROLES] = $rolesResponse;
            }

            $roles = $rolesResponse->getRoles();
            $rol_id = (int) @$_POST['rol_id'];

            $errorMenssages = [];

            if ($rol_id === null || $rol_id < 1) {
                $errorMenssages["rol"] = "Es requerido";
                new Exception("El Rol es requerido");
            }

            $rolSelected = array_filter($roles, function ($rol) use ($rol_id) {
                return $rol->getId() === $rol_id; // Filtrar por ID
            });
            
            // Comprobar si se encontró algún rol
            if (empty($rolSelected)) {
                throw new Exception("No tiene permisos suficientes");
            }
  
            $rolSelected = reset($rolSelected);

            if (
                $userLogin->getRol() === RolTypeEnum::SUPERVISOR
                && $rolSelected->getNombre() === RolTypeEnum::SUPER_USUARIO
            ) {
                throw new InvalidPermissionException("No tiene permisos para crear Super Usuarios");
            }

            if (
                $userLogin->getRol() === RolTypeEnum::SUPERVISOR
                && $rolSelected->getNombre() === RolTypeEnum::SUPERVISOR
            ) {
                throw new InvalidPermissionException("No tiene permisos para crear Usuarios Supervisores");
            }

            $email = isset($_POST['email']) && !empty(trim($_POST['email'])) ? $_POST['email'] : null;
            $nombre = isset($_POST['nombre']) && !empty(trim($_POST['nombre'])) ? $_POST['nombre'] : null;
            $password = Utility::generateGUID(2);

            $errorMenssages = [];
            if ($email === null) {
                $errorMenssages["email"] = "Es requerido";
            }

            if ($nombre === null) {
                $errorMenssages["nombre"] = "Es requerido";
            }

            if (count($errorMenssages) > 0) {
                $errorMenssages["error"] = "Formulario mal diligenciado";
                echo json_encode($errorMenssages);
                exit;
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
            $transacctionDb->commit();
            $response = array(
                "id" => $createUserResponse->getId(),
                "message" => $emailResponse
            );
            echo json_encode($response);
            exit();
        } catch (Exception $e) {
            $transacctionDb->rollback();
            $error = ["error"=> $e->getMessage()];
            echo json_encode($error);
            exit;
        }
    }

    private function showFormCreateUser()
    {
        $rolesResponse = DependencyInjection::getRolesServce()->getRoles();
        $_SESSION[ItemsInSessionEnum::LIST_ROLES] = $rolesResponse;
        header("Location: ../../Views/Users/create.php");
        exit;

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
