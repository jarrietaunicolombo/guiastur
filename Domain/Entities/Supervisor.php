<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/guiastur/Infrastructure/Libs/Orm/Config.php";

class Supervisor  extends  ActiveRecord\Model {
<<<<<<< Updated upstream
    public static $table_name = "Supervisores";
=======
>>>>>>> Stashed changes
    public static $primary_key = "cedula";
    public static $belongs_to = array(array("usuario"));
    public static $has_many = array(array("atenciones"));
}
