<?php

namespace Api\Repositories;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Buque.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/DuplicateEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/Utility.php";

use Exception;

class BuqueMobileRepository {
    /**
     * Buscar buque por ID
     */
    public function findById($id) {
        try {
            return \Buque::find($id);
        } catch (Exception $e) {
            throw \Utility::errorHandler($e);
        }
    }

    /**
     * Obtener todos los buques
     */
    public function findAll($page = 1, $perPage = 20) {
        try {
            $offset = ($page - 1) * $perPage;
    
            $allBuques = \Buque::all();
    
            $total = count($allBuques);
    
            $buques = array_slice($allBuques, $offset, $perPage);
    
            $data = [];
            foreach ($buques as $buque) {
                $data[] = [
                    'id' => $buque->id ?? null,
                    'nombre' => $buque->nombre ?? '',
                    'codigo' => $buque->codigo ?? '',
                    'fecha_registro' => isset($buque->fecha_registro) ? $buque->fecha_registro->format('Y-m-d H:i:s') : null,
                    'usuario_registro' => $buque->usuario_registro ?? null,
                ];
            }
    
            return [
                "status" => "success",
                "total" => $total,
                "perPage" => $perPage,
                "currentPage" => $page,
                "data" => $data
            ];
        } catch (Exception $e) {
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }
    
    /**
     * Crear un buque
     */
    public function create($nombre, $codigo, $usuarioRegistro) {
        try {
            $buque = \Buque::create([
                "nombre" => $nombre,
                "codigo" => $codigo,
                "fecha_registro" => (new \DateTime())->format('Y-m-d H:i:s'),
                "usuario_registro" => (int) $usuarioRegistro
            ]);
            if (!$buque) {
                throw new \Exception("No se pudo crear el buque.");
            }
    
            return $buque->to_array();
        } catch (Exception $e) {
            throw \Utility::errorHandler($e);
        }
    }
}
