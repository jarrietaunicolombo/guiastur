<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetUsusarioByToken/Dto/GetUsuarioByTokenRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetUsusarioByToken/Dto/GetUsuarioByTokenResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetUsusarioByToken/Dto/UpdateUsuarioByActivatedRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetUsusarioByToken/Dto/UpdateUsuarioByActivatedResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserGuiaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserGuiaResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserSupervisorRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserSupervisorResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Model/EmailDestinationModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidPermissionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/ConnectionDbException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InternalErrorException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidRequestParameterException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidActivationException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/RolTypeEnum.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Controllers/SessionUtility.php";
// CreateUserGuiaRequest
class ActivateUserAccountController
{

    public function handleRequest(array $request)
    {
        $action = $request["action"];
        if ($action == "activate") {
            $this->showFormActivateAccount($request);
            return;
        }
        if ($action == "activating") {
            $this->activateAccount($request);
            return;
        } else {

        }
    }

    public function activateAccount(array $request)
    {
        try {
            $trasactionDb = DependencyInjection::getTransactionManager();
            SessionUtility::startSession();
            $action = $request["action"];

            if ($action !== "activating") {
                throw new InvalidPermissionException();
            }

            $userActivating = @$_SESSION[ItemsInSessionEnum::USER_ACTIVATING];
            if ($userActivating == null) {
                throw new InvalidPermissionException();
            }

            $token = @$request["token"];
            if ($token == null) {
                throw new InvalidPermissionException();
            }
            if ($userActivating->getToken() !== $token) {
                throw new InvalidPermissionException();
            }

            $errorMessages = array();

            if ($userActivating->getRolNombre() == RolTypeEnum::GUIA || $userActivating->getRolNombre() == RolTypeEnum::SUPERVISOR) {

                if (!isset($request["cedula"]) || empty(trim($request["cedula"]))) {
                    $errorMessages["cedula"] = "Es requerido";
                }

                if (!isset($request["rnt"]) || empty(trim($request["rnt"]))) {
                    $errorMessages["rnt"] = "Es requerido";
                }


                if (!isset($request["nombres"]) || empty(trim($request["nombres"]))) {
                    $errorMessages["nombres"] = "Es requerido";
                }

                if (!isset($request["apellidos"]) || empty(trim($request["apellidos"]))) {
                    $errorMessages["apellidos"] = "Es requerido";
                }

                if (!isset($request["genero"]) || empty(trim($request["genero"]))) {
                    $errorMessages["genero"] = "Es requerido";
                }

                if (!isset($request["fecha_nacimiento"]) || empty(trim($request["fecha_nacimiento"]))) {
                    $errorMessages["fecha_nacimiento"] = "Es requerido";
                }

                $fechaNacimiento = DateTime::createFromFormat("Y-m-d", $request["fecha_nacimiento"]);
                if ($fechaNacimiento === false) {
                    $errorMessages["fecha_nacimiento"] = "Formato: AAAA-MM-DDD";
                }

                if ($fechaNacimiento > new DateTime()) {
                    $errorMessages["fecha_nacimiento"] = "Incorrecta";
                }

                if (!isset($request["telefono"]) || empty(trim($request["telefono"]))) {
                    $errorMessages["telefono"] = "Es requerido";
                }
            }
            if (!isset($request["pass"]) || empty(trim($request["pass"]))) {
                $errorMessages["pass"] = "Es requerida";
            }

            if (!isset($request["new_pass1"]) || empty(trim($request["new_pass1"]))) {
                $errorMessages["new_pass1"] = "Es requerida";
            }

            if (!isset($request["new_pass2"]) || empty(trim($request["new_pass2"]))) {
                $errorMessages["new_pass2"] = "Es requerida";
            }

            if ($userActivating->getPassword() != $request["pass"]) {
                $errorMessages["pass"] = "Password incorrecto, revise su correo electronico";
            }

            if ($request["new_pass1"] !== $request["new_pass2"]) {
                $errorMessages["new_pass1"] = "Nuevos password no son iguales";
            }

            if (count($errorMessages) > 0) {
                throw new InvalidRequestParameterException();
            }

            $trasactionDb->begin();
            $createUserRequest = null;
            $createUserService = null;
            if ($userActivating->getRolNombre() == RolTypeEnum::GUIA) {
                $createUserRequest = new CreateUserGuiaRequest(
                    $userActivating->getId(),
                    $userActivating->getEmail(),
                    $request["new_pass1"],
                    $userActivating->getNombre(),
                    $userActivating->getRolId(),
                    $userActivating->getRolNombre(),
                    $userActivating->getToken(),
                    $request["cedula"],
                    $request["rnt"],
                    $request["nombres"],
                    $request["apellidos"],
                    $request["genero"],
                    $fechaNacimiento,
                    $request["telefono"],
                    null, // Foto
                    null, // Observaciones
                    $userActivating->getId()
                );
                $createUserService = DependencyInjection::getCreateUserGuiaServce();
            } else if ($userActivating->getRolNombre() == RolTypeEnum::SUPERVISOR) {
                $createUserRequest = new CreateUserSupervisorRequest(
                    $userActivating->getId(),
                    $userActivating->getEmail(),
                    $userActivating->getPassword(),
                    $userActivating->getNombre(),
                    $userActivating->getRolId(),
                    $userActivating->getRolNombre(),
                    $userActivating->getToken(),
                    $request["cedula"],
                    $request["rnt"],
                    $request["nombres"],
                    $request["apellidos"],
                    $request["genero"],
                    $fechaNacimiento,
                    $request["telefono"],
                    null, // Foto
                    null, // Observaciones
                    $userActivating->getId()
                );
                $createUserService = DependencyInjection::getCreateUserSupervisorServce();
            }

            if (!isset($createUserService) && $userActivating->getRolNombre() !== RolTypeEnum::SUPER_USUARIO && $userActivating->getRolNombre() !== RolTypeEnum::USUARIO) {
                throw new InvalidPermissionException("Sin permisos para realizar esta accion");
            }
            if (isset($createUserService)) {
                $createUserResponse = $createUserService->CreateUser($createUserRequest);
            }

            $updateUsuarioByActivatedCommand = DependencyInjection::getUpdateUsuarioByActivatedCommand();

            $updateRequest = new UpdateUsuarioByActivatedRequest(
                $userActivating->getId(),
                $request["cedula"]?? $userActivating->getId() ,
                $request["new_pass1"]
            );
            $updadeResponse = $updateUsuarioByActivatedCommand->handler($updateRequest);

            $trasactionDb->commit();

            $subject = "Cuanta de usuario " . $userActivating->getRolNombre() . " Activada";
            $body = $this->generateBodyMessage($updadeResponse);
            $emailDestinationModel = new EmailDestinationModel(
                $updadeResponse->getEmail(),
                $updadeResponse->getNombre(),
                $subject,
                $body
            );
            $emailSenderService = DependencyInjection::getEmailSenderServce();
            $emailResponse = $emailSenderService->send($emailDestinationModel);

            session_destroy();
            SessionUtility::startSession();
            $_SESSION[ItemsInSessionEnum::INFO_MESSAGE] = "Usuario Activado. $emailResponse";
            header("Location: ../../Views/Users/login.php");

        } catch (InvalidRequestParameterException $e) {
            $trasactionDb->rollback();
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGES] = $errorMessages;
            $_SESSION[ItemsInSessionEnum::USER_REQUEST_ACTIVATING] = $request;
            header("Location: ../../Views/Users/activate.php");
        } catch (DuplicateEntryException $e) {
            $trasactionDb->rollback();
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGES] = $errorMessages;
            $error = "Ya existe un usuario registrado con CC: " . $request["cedula"];
            $error = (strstr($e->getMessage(), "PRIMARY")) ? $error : $e->getMessage();
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $error;
            $_SESSION[ItemsInSessionEnum::USER_REQUEST_ACTIVATING] = $request;
            header("Location: ../../Views/Users/activate.php");
        } catch (Exception $e) {
            $trasactionDb->rollback();
            $errorMessage = $e->getMessage();
            $this->showLoginForInvidateOperation($errorMessage);
        }
    }

    public function showFormActivateAccount(array $request)
    {
        SessionUtility::startSession();
        try {
            $id = @$request["id"];
            if (!isset($id)) {
                throw new InvalidPermissionException("Acceso denegado");
            }

            $token = @$request["token"];
            if (!isset($token)) {
                throw new InvalidPermissionException("Acceso denegado");
            }

            $getUserByTokenRequest = new GetUsuarioByTokenRequest($id, $token);
            $getUsuarioByTokenQuery = DependencyInjection::getUsuarioByTokenQuery();
            $userResponse = $getUsuarioByTokenQuery->handler($getUserByTokenRequest);
            $_SESSION[ItemsInSessionEnum::USER_ACTIVATING] = $userResponse;
            header("Location: ../../Views/Users/activate.php");
            exit;
        } 
        catch (InvalidActivationException $e) {
            $errorMessage = $e->getMessage();
            SessionUtility::clearAllSession();
            SessionUtility::startSession();
            $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $errorMessage;
            header("Location: ../../Views/Users/activate.php");
            exit;
        }
        catch (Exception $e) {
            $errorMessage = $e->getMessage();
            $this->showLoginForInvidateOperation($errorMessage);
            exit;
        }
    }

    public function showLoginForInvidateOperation(string $errorMessage = null)
    {
        session_destroy();
        SessionUtility::startSession();
        $_SESSION[ItemsInSessionEnum::ERROR_MESSAGE] = $errorMessage ?? 'Accion invalida';
        header("Location: ../../Views/Users/login.php");
    }

    private function generateBodyMessage(UpdateUsuarioByActivatedResponse $response)
    {
        $nombre = $response->getNombre();
        $email = $response->getEmail();
        $rol = $response->getRolNombre();
        $password = $response->getPassword();
        $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $uri = "/Views/Users/login.php";
        $parameters = "";
        $url = UrlHelper::getUrl($uri);
        $url .= $parameters;
        $template = "../../Views/Users/TemplateNotificacionActivatedUser.html";
        $htmlTemplate = file_get_contents($template);
        $htmlContent = str_replace(
            ['[[nombre]]', '[[email]]', '[[pass]]', '[[rol]]', '[[url]]'],
            [$nombre, $email, $password, $rol, $url],
            $htmlTemplate
        );
        return $htmlContent;
    }
}