<?php

namespace Api\Models;

use ActiveRecord\Model;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Libs/Orm/activerecord/ActiveRecord.php";

class UserToken extends Model
{
    static $table_name = 'user_tokens';
    static $primary_key = 'id';

    public static $validates_presence_of = array(
        array('usuario_id'),
        array('token'),
        array('expira_el')
    );
}
