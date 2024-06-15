<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/guiastur/Infrastructure/Libs/Orm/Config.php";

class Atencion extends ActiveRecord\Model {
    public static $table_name = "Atenciones";
    public static $belongs_to = array(array("recalada"), array("supervisor"));
    public static $has_many = array(array("turnos")); 
}

