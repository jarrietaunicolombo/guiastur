<?php
require_once $_SERVER["DOCUMENT_ROOT"] ."guiastur/Application/Contracts/Repositories/ITransactionManager.php";
require_once $_SERVER["DOCUMENT_ROOT"] ."guiastur/Infrastructure/Libs/Orm/Config.php";

class TransactionManager implements ITransactionManager{
    private $connectionDb;

    public function __construct() {
        $this->connectionDb = ConnectionManager::get_connection();
    }

    public function begin() {
        $this->connectionDb->transaction();
    }

    public function commit() {
        $this->connectionDb->commit();
    }

    public function rollback() {
        $this->connectionDb->rollback();
    }
}