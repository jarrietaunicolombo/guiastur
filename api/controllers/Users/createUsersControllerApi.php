<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/DependencyInjection.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/CreateUser/Dto/CreateUserResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Constants/RolTypeEnum.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/Utility.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Model/EmailDestinationModel.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Exceptions/UnauthorizedException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Exceptions/ValidationException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/JWTHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/Helpers/CookiesSetup.php"; // Incluir el controlador de Cookies

use Api\Exceptions\UnauthorizedException;
use Api\Exceptions\ValidationException;
use Api\Helpers\JWTHandler;
use Api\Helpers\CookiesSetup;

class CreateUserController
{
    public function handleRequest($request)
    {
        $accion = @$request["action"];
        if ($accion === "create") {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                $this->createUser($request);
            } else {
                $this->sendErrorResponse("Método no permitido", 405);
            }
        } else {
            $this->sendErrorResponse("Acción inválida", 400);
        }
    }

    private function createUser(array $request)
    {
        $transacctionDb = DependencyInjection::getTransactionManager();
        try {
            $transacctionDb->begin();

            $cookies = new CookiesSetup();
            $token = $cookies->getAuthTokenFromCookie();

            $decodedToken = $this->validateAndExtractTokenData($token);

            $rolesResponse = DependencyInjection::getRolesServce()->getRoles();
            if (empty($rolesResponse)) {
                throw new Exception("No existen roles disponibles.");
            }

            $roles = $rolesResponse->getRoles();
            $rol_id = (int) @$request['rol_id'];
            if ($rol_id < 1) {
                throw new ValidationException("El rol es requerido.");
            }

            $rolSelected = array_filter($roles, function ($rol) use ($rol_id) {
                return $rol->getId() === $rol_id;
            });

            if (empty($rolSelected)) {
                throw new UnauthorizedException("Rol no autorizado.");
            }

            $rolSelected = reset($rolSelected);

            $email = $this->validateEmail($request['email']);
            $nombre = $this->validateNombre($request['nombre']);
            $password = Utility::generateGUID(2);

            $createUserRequest = new CreateUserRequest(
                $email,
                $password,
                $nombre,
                $rol_id,
                $decodedToken->data->userId
            );

            $createUserUseCase = DependencyInjection::getCreateUserServce();
            $createUserResponse = $createUserUseCase->createUser($createUserRequest);

            // Enviar correo de confirmación
            $this->sendConfirmationEmail($createUserResponse);

            $transacctionDb->commit();

            $this->sendSuccessResponse([
                "id" => $createUserResponse->getId(),
                "message" => "Usuario creado exitosamente."
            ]);
        } catch (UnauthorizedException $e) {
            $transacctionDb->rollback();
            $this->sendErrorResponse($e->getMessage(), 403);
        } catch (ValidationException $e) {
            $transacctionDb->rollback();
            $this->sendErrorResponse($e->getMessage(), 422);
        } catch (Exception $e) {
            $transacctionDb->rollback();
            $this->sendErrorResponse($e->getMessage(), 400);
        }
    }

    private function validateAndExtractTokenData($token)
    {
        if (!JWTHandler::validateToken($token)) {
            throw new UnauthorizedException("Token inválido o expirado.");
        }

        $decodedToken = JWTHandler::decodeJWT($token);

        return $decodedToken;
    }

    private function validateEmail($email)
    {
        if (!isset($email) || empty(trim($email))) {
            throw new ValidationException("El Email es requerido.");
        }
        return $email;
    }

    private function validateNombre($nombre)
    {
        if (!isset($nombre) || empty(trim($nombre))) {
            throw new ValidationException("El Nombre es requerido.");
        }
        return $nombre;
    }

    private function sendConfirmationEmail(CreateUserResponse $response)
    {
        $subject = "Usuario " . $response->getRolNombre() . " creado";
        $bodyMessage = $this->generateBodyMessage($response);
        $emailDestinationModel = new EmailDestinationModel(
            $response->getEmail(),
            $response->getNombre(),
            $subject,
            $bodyMessage
        );

        $emailServerService = DependencyInjection::getEmailSenderServce();
        $emailResponse = $emailServerService->send($emailDestinationModel);
        if (strpos($emailResponse, "No pudo ser enviada") !== false) {
            throw new Exception($emailResponse);
        }
    }

    private function generateBodyMessage(CreateUserResponse $response)
    {
        $nombre = $response->getNombre();
        $email = $response->getEmail();
        $rol = $response->getRolNombre();
        $password = $response->getPassword();

        $template = $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Views/Users/TemplateNotificacionNewUser.html";
        if (!file_exists($template)) {
            throw new Exception("El archivo de plantilla no se encontró en la ruta especificada.");
        }

        $htmlTemplate = file_get_contents($template);

        $htmlContent = str_replace(
            ['[[nombre]]', '[[email]]', '[[pass]]', '[[rol]]'],
            [$nombre, $email, $password, $rol],
            $htmlTemplate
        );
        return $htmlContent;
    }

    private function sendSuccessResponse($data)
    {
        echo json_encode($data);
        http_response_code(200);
        exit();
    }

    private function sendErrorResponse($message, $code = 400)
    {
        echo json_encode(["error" => $message]);
        http_response_code($code);
        exit();
    }
}
