<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/guiastur/Infrastructure/Libs/Orm/Config.php";

class Pais  extends  ActiveRecord\Model {
    public static $has_many = array(array("recladas"));
}


