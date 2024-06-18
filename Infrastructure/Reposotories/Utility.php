<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/DuplicateEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/ConnectionDbException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/InternalErrorException.php";
class Utility
{

    public static function getDuplicateRecordInfo($mensaje): array
    {
        $duplicateText = "Duplicate entry";
        if (!isset($mensaje) || empty(trim($mensaje))) {
            return array();
        }
        if (strstr($mensaje, $duplicateText) == false) {
            return array();
        }
        $result = array();
        $patron = "/Duplicate entry '([^']+)' for key '([^']+)'/";
        $matches = [];
        $resultado = [];
        if (preg_match($patron, $mensaje, $matches)) {
            $result[UtilConstantsEnum::COLUMN_NAME] = $matches[2];
            $result[UtilConstantsEnum::COLUMN_VALUE] = $matches[1];
        }
        return $result;
    }

    public static function getNotFoundRecordInfo($mensaje): array
    {
        
        $TextToSearch = "Couldn't find";
        if (!isset($mensaje) || empty(trim($mensaje))) {
            return array();
        }
        
        if (strstr($mensaje, $TextToSearch) == false) {
            return array();
        }

        $pattern = "/Couldn't find ([a-zA-Z]+) with ID=(\d+)/";
        $matches = [];
        $result = array();

        if (preg_match($pattern, $mensaje, $matches)) {
        
            $result[UtilConstantsEnum::TABLE_NAME] = $matches[1];
            $result[UtilConstantsEnum::COLUMN_VALUE] = $matches[2];

        } 
        return $result;
    }

    public static function getFieldNameNotNull($errorMessage) : string{
        $TextToSearch = "doesn't have a default value";
        $EmptyString = '';
        if (!isset($errorMessage) || empty(trim($errorMessage))) {
            return $EmptyString;
        }
        
        if (strstr($errorMessage, $errorMessage) == false) {
            return $EmptyString;
        }

        $pattern = "/Field '(.*?)' doesn't have a default value/";
        if (preg_match($pattern, $errorMessage, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public static function errorHandler($error): Exception{
        $errorMessage = $error->getMessage();
        if(strstr($errorMessage,UtilConstantsEnum::DB_DISCONECT_ERROR_CODE)){
            return new ConnectionDbException();
        }
        if(strstr($errorMessage,UtilConstantsEnum::DB_PERISIONS_CONNECT_ERROR_CODE)){
            return new ConnectionDbException("Sin permisos de acceso a la BD");
        }
        if(strstr($errorMessage,UtilConstantsEnum::DB_SELECT_ERROR_CODE)){
            return new InternalErrorException("Nombre incorrecto de la BD");
        }
        if(strstr($errorMessage,UtilConstantsEnum::DB_TABLE_NAME_ERROR_CODE)){
            return new InternalErrorException("La tabla no existe");
        }
        return $error;

    }

    public static function generateGUID($len)
    {
        $data = str_replace('.', '', uniqid('', true));
        $parts = [
            1 => substr($data, 0, 8) . '-' . substr($data, 8, 4),
            2 => substr($data, 0, 8) . '-' . substr($data, 8, 4) 
                . '-' . substr($data, 12, 4),
            3 => substr($data, 0, 8) . '-' . substr($data, 8, 4) 
                . '-' . substr($data, 12, 4) . '-' . substr($data, 16, 4),
            4 => substr($data, 0, 8) . '-' . substr($data, 8, 4) 
                . '-' . substr($data, 12, 4) . '-' . substr($data, 16, 4) 
                . '-' . substr($data, 20),
        ];
    
        return isset($parts[$len]) ? $parts[$len] : $parts[1];
    }
    
}

abstract class UtilConstantsEnum
{
    const COLUMN_NAME = "COLUMN_NAME";
    const TABLE_NAME = "TALBE_NAME";
    const COLUMN_VALUE = "COLUMN_VALUE";
    const DB_DISCONECT_ERROR_CODE = "SQLSTATE[HY000] [2002]";
    const DB_KEY_DUPLICATE_ERROR_CODE = "SQLSTATE[23000]";
    const DB_PERISIONS_CONNECT_ERROR_CODE = "SQLSTATE[HY000] [1045]";
    const DB_SELECT_ERROR_CODE = "SQLSTATE[HY000] [1049]";
    const DB_TABLE_NAME_ERROR_CODE = "SQLSTATE[42S02]";
    const DB_NOT_FOUND_ERROR = "Couldn't find";
    const DB_FIELD_NOT_NULL_ERROR = "SQLSTATE[HY000]: General error: 1364";
    
    // PDOException: SQLSTATE[23000]: Integrity constraint violation: 1452 Cannot add or update a child row: a foreign key constraint fails (`gestion_turnos_guias_bd`.`supervisors`, CONSTRAINT `Fk_Usuarios_Supervisores` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`))
}