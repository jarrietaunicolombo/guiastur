<?php
require_once $_SERVER["DOCUMENT_ROOT"] ."/guiastur/Application/Contracts/Repositories/ITransactionManager.php";
require_once $_SERVER["DOCUMENT_ROOT"] ."/guiastur/Infrastructure/Libs/Orm/Config.php";
use ActiveRecord\ConnectionManager;
class TransactionManager implements ITransactionManager{
    private $connectionDb;

    public function __construct() {
        $this->connectionDb = ConnectionManager::get_connection();
    }

    public function begin() {
        $this->connectionDb->transaction();
    }

    public function commit() {
        if ($this->connectionDb->connection->inTransaction()) {
             $this->connectionDb->commit();
        }
    }

    public function rollback() {
       if ($this->connectionDb->connection->inTransaction()) {
            $this->connectionDb->rollback();
        }
    }
}