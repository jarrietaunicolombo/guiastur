<?php
class SessionUtility
{
    public static function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function clearAllSession()
    {
        $itemsInSession = ItemsInSessionEnum::getConstansValues();
        foreach ($itemsInSession as $value ) {
            $itemsInSession[$value] = null;
            unset($itemsInSession[$value]);
        }
        session_unset();
        session_destroy();
    }

    public static function deleteItemInSession(string $item){
        @$_SESSION[$item] = null;
        unset($_SESSION[$item]);
    }
}

abstract class ItemsInSessionEnum
{
    const USER_LOGIN = "User.Login";
    const USER_PERMISSION = "User.Permission";
    const USER_ACTIVATING = "User.Activating";
    const USER_REQUEST_ACTIVATING = "User.Request.Activating";
    const FOUND_USER = "User.Find";
    const LIST_USERS = "User.List";
    const FOUND_GUIA = "Guia.Find";
    const LIST_GUIAS = "Guia.List";
    const FOUND_SUPERVISOR = "Supervisor.Find";
    const LIST_SUPERVISORES = "Supervisor.List";
    const FOUND_BUQUE = "Buque.Find";
    const LIST_BUQUES = "Buque.List";
    const FOUND_PAIS = "Pais.Find";
    const LIST_PAISES = "Pais.List";
    const FOUND_ROL = "Rol.Find";
    const LIST_ROLES = "Rol.List";
    const FOUND_RECALADA = "Recalada.Find";
    const LIST_RECALADAS = "Recalada.List";
    const FOUND_ATENCION = "Atencion.Find";
    const LIST_ATENCIONES = "Atencion.List";
    const FOUND_TURNO = "Turno.Find";
    const LIST_TURNOS = "Turno.List";
    const ERROR_MESSAGE = "Error.Message";
    const INFO_MESSAGE = "Information.Message";
    const ERROR_MESSAGES = "Error.Messages";

    public static function getConstansValues(): array
    {
        $reflect = new ReflectionClass(__CLASS__);
        $constProperties = $reflect->getConstants();
        $values = array();
        foreach ($constProperties as $constantName => $value) {
            $values[] = $value;
        }
        return $values;
    }
}



// Clase utilitaria para manejar URLs
class UrlHelper
{
    public static function getUrl($uri)
    {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $port = $_SERVER['SERVER_PORT'];
        $baseUrl = $protocol . $host;
        if (($protocol === 'http://' && $port != 80) || ($protocol === 'https://' && $port != 443)) {
            $baseUrl .= ":" . $port;
        }
        $fullUrl = $baseUrl . "/guiastur" . $uri;
        return $fullUrl;
    }
}
