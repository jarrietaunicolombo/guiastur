<?php

namespace Api\Services\Utilities;

class UtilityService
{

    public function generatePassword()
    {
        return bin2hex(random_bytes(8));
    }

    public function generateGUID($length = 16)
    {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        } else {
            mt_srand((float) microtime() * 10000);
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $guid = substr($charid, 0, $length);
            return $guid;
        }
    }

    // Puedes agregar más métodos de utilidad que se usen en varios lugares del proyecto
}
