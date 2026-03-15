<?php

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Usuario.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Rol.php";
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

    public function getAllRoles()
    {
        try {
            error_log("📦 UserMobileRepository: Buscando todos los roles");
            $roles = \Rol::all();
    
            if (!$roles) {
                error_log("⚠️ UserMobileRepository: No se encontraron roles");
                throw new NotFoundEntryException("No se encontraron roles.");
            }
    
            error_log("✅ UserMobileRepository: Roles encontrados - total: " . count($roles));
            return $roles;
        } catch (Exception $e) {
            error_log("❌ UserMobileRepository: Error al obtener roles - " . $e->getMessage());
            throw new NotFoundEntryException("Error al obtener roles: " . $e->getMessage());
        }
    }
}
