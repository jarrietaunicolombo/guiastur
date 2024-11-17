<?php

namespace Api\Models;

use ActiveRecord\Model;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Libs/Orm/activerecord/ActiveRecord.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Libs/Orm/Config.php";

class UserToken extends Model
{
    static $table_name = 'user_tokens';
    static $primary_key = 'id';

    public static $validates_presence_of = array(
        array('usuario_id'),
        array('token'),
        array('expira_el')
    );

    public function getUsuario()
    {
        $sql = "SELECT * FROM usuarios WHERE id = ?";
        $usuario = self::connection()->query($sql, [$this->usuario_id]);
        return $usuario ? $usuario->fetch() : null;
    }

    public function getUsuarioRol()
    {
        $usuario = $this->getUsuario();
        if ($usuario) {
            $sql = "SELECT * FROM roles WHERE id = ?";
            $rol = self::connection()->query($sql, [$usuario['rol_id']]);
            return $rol ? $rol->fetch() : null;
        }
        return null;
    }
}
