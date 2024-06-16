<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/guiastur/Infrastructure/Libs/Orm/Config.php";

class Rol  extends  ActiveRecord\Model {
<<<<<<< Updated upstream
    public static $table_name = "Roles";
=======
>>>>>>> Stashed changes
    public static $has_many = array(array("usuarios"));
}

