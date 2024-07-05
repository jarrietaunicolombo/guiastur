<?php
interface ITransactionManager {
    public function begin();
    public function commit();
    public function rollback();
}