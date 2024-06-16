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
        
        $duplicateText = "Couldn't find";
        if (!isset($mensaje) || empty(trim($mensaje))) {
            return array();
        }
        
        if (strstr($mensaje, $duplicateText) == false) {
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
}