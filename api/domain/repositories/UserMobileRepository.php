<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Usuario.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/Exceptions/NotFoundEntryException.php";

use Api\Exceptions\NotFoundEntryException;

class UserMobileRepository
{
    public function findById(int $id)
    {
        try {
            $user = Usuario::find($id);
            if (!$user) {
                throw new NotFoundEntryException("Usuario no encontrado con ID: $id");
            }
            return $user;
        } catch (Exception $e) {
            throw new NotFoundEntryException("Usuario no encontrado con ID: $id");
        }
    }
}
