<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/guiastur/Infrastructure/Libs/Orm/Config.php";

class Recalada  extends  ActiveRecord\Model {
    public static $belongs_to = array(array("buque"), array("pais"));
    public static $has_many = array(array("atenciones"));
}

