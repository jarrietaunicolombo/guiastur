<?php
session_start();
// require_once '../Application/UseCases/GetRoles/GetRolesService.php';
require_once '../../DependencyInjection.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Repositories/Utility.php";


class CreateUserController
{
    public function createUser()
    {
        $roles = unserialize(@$_SESSION["Roles.All"]);
        if (!isset($roles) || count($roles) <1 ){
            $roles = DependencyInjection::getRolesServce()->getRoles();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                // Recibir los datos del formulario
                $email = $_POST['email'];
                $password = Utility::generateGUID(2);
                $nombre = $_POST['nombre'];
                $rol_id = $_POST['rol_id'];
                $usuario_registro = $_POST['usuario_registro'];
                $createUserRequest = new CreateUserRequest($email, $password, $nombre, $rol_id, $usuario_registro);
                $createUserUseCase = DependencyInjection::getCreateUserServce();
                $createUserResponse = $createUserUseCase->createUser($createUserRequest);
                $subjetMessage = "Tiene un usuario creado en Sistema de gestion de turnos para guias Turistas";
                $bodyMessage = $this->generateBodyMessage($createUserResponse);
                $emailDestinationModel = new EmailDestinationModel(
                    $createUserResponse->getUsuario()->getEmail(),
                    $createUserResponse->getUsuario()->getNombre(),
                    $subjetMessage,
                    $bodyMessage
                );
                $emailServerService = DependencyInjection::getEmailSenderServce();
               $emailResponse =  $emailServerService->send($emailDestinationModel);
                // Guardar la respuesta en la sesión
                $_SESSION['createUserResponse'] = $createUserResponse;
                
                // Redirigir a la vista de mostrar usuario
                header("Location: ../../Views/Users/index.php?action=create_user&message=$emailResponse");
                exit();
            } catch (Exception $e) {
                $error = 'Error al Crear Usuario: ' . $e->getMessage();
                $this->showCreateForm($error);
            }
        } else {
            // Obtener los roles usando el servicio
            $rolesService = DependencyInjection::getRolesServce();
            $rolesResponse = $rolesService->getRoles();
            $roles = $rolesResponse->getRoles();
            // Mostrar el formulario con los roles
            $this->showCreateForm(null, $roles);
        }
    }

    private function showCreateForm($error = null, $roles = [])
    {
        $accion = "show_user";
        require_once '../../Views/Users/create.php';
    }

    private function generateBodyMessage(CreateUserResponse $response) {
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
            ['[[nombre]]', '[[email]]','[[pass]]' ,'[[rol]]', '[[url]]'],
            [$nombre, $email, $password, $rol, $url],
            $htmlTemplate
        );
        return $htmlContent;
    }   
}
