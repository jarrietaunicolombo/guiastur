<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/DuplicateEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/ConnectionDbException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InternalErrorException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InternalErrorException.php";

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

    public static function getFieldNameNotNull($errorMessage): string
    {
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

    public static function getReferencedTableNames($errorMessage): array
    {
        $TextToSearch = "a foreign key constraint fails";

        if (!isset($errorMessage) || empty(trim($errorMessage))) {
            return array();
        }

        if (strstr($errorMessage,  $TextToSearch) == false) {
            return  array();
        }
        $pattern = '/`.`(.*?)`\s*,\s*CONSTRAINT/';
        $tableName = preg_match($pattern, $errorMessage, $matches)? $matches[1] : null;
        $referencedTableName = preg_match('/REFERENCES `(.*?)`/', $errorMessage, $matches) ? $matches[1] : null;

        return [
            UtilConstantsEnum::TABLE_NAME => $tableName,
            UtilConstantsEnum::TABLE_REFERENCE_NAME => $referencedTableName
        ];
    }

    public static function generateGUID($len = 4)
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


    public static function errorHandler($error): Exception
    {
        $errorMessage = $error->getMessage();
        if (strstr($errorMessage, UtilConstantsEnum::DB_DISCONECT_ERROR_CODE)) {
            return new ConnectionDbException();
        }
        if (strstr($errorMessage, UtilConstantsEnum::DB_PERISIONS_CONNECT_ERROR_CODE)) {
            return new ConnectionDbException("Sin permisos de acceso a la BD");
        }
        if (strstr($errorMessage, UtilConstantsEnum::DB_SELECT_ERROR_CODE)) {
            return new InternalErrorException("Nombre incorrecto de la BD");
        }
        if (strstr($errorMessage, UtilConstantsEnum::DB_TABLE_NAME_ERROR_CODE)) {
            return new InternalErrorException("La tabla no existe");
        }
        if (strstr($errorMessage, UtilConstantsEnum::DB_FORIGN_KEY_REFERENCE)) {
            $result = Utility::getReferencedTableNames($errorMessage);
            $message = "Operación rechazada: Existe relacion ". strtoupper($result[UtilConstantsEnum::TABLE_NAME]) . " y " . strtoupper($result[UtilConstantsEnum::TABLE_REFERENCE_NAME]);
            return new EntityReferenceNotFoundException($message);
        }
        return $error;
    }
}

abstract class UtilConstantsEnum
{
    const COLUMN_NAME = "COLUMN_NAME";
    const TABLE_NAME = "TALBE_NAME";
    const TABLE_REFERENCE_NAME = "TABLE_REFERENCE_NAME";
    const COLUMN_VALUE = "COLUMN_VALUE";
    const DB_DISCONECT_ERROR_CODE = "SQLSTATE[HY000] [2002]";
    const DB_KEY_DUPLICATE_ERROR_CODE = "SQLSTATE[23000]";
    const DB_PERISIONS_CONNECT_ERROR_CODE = "SQLSTATE[HY000] [1045]";
    const DB_SELECT_ERROR_CODE = "SQLSTATE[HY000] [1049]";
    const DB_TABLE_NAME_ERROR_CODE = "SQLSTATE[42S02]";
    const DB_NOT_FOUND_ERROR = "Couldn't find";
    const DB_FIELD_NOT_null_ERROR = "SQLSTATE[HY000]: General error: 1364";
    const DB_FORIGN_KEY_REFERENCE = "a foreign key constraint fails";
}
