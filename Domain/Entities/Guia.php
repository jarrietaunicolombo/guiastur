<?php
require_once $_SERVER["DOCUMENT_ROOT"]."/guiastur/Infrastructure/Libs/Orm/Config.php";

class Guia  extends  ActiveRecord\Model {
    public static $primary_key = "cedula";
    public static $belongs_to = array(array("usuario"));
    public static $has_many = array(array("turnos"),array("gestionturnos") );
}
