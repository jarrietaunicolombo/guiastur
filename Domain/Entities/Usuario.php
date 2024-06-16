<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/guiastur/Infrastructure/Libs/Orm/Config.php";

class Usuario  extends  ActiveRecord\Model {
    public static $belongs_to = array(array("rol"));
<<<<<<< Updated upstream
    public static $has_many = array(array("guias"), array("supervisores"));
=======
    public static $has_many = array(array("guias"), array("supervisors"));

>>>>>>> Stashed changes
}

