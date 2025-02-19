<?php

namespace Api\Repositories;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Recalada.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/DuplicateEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Infrastructure/Repositories/Utility.php";

use Exception;

class RecaladaMobileRepository {
    /**
     * Buscar recalada por ID
     */
    public function findById($id) {
        try {
            return \Recalada::find($id);
        } catch (Exception $e) {
            throw \Utility::errorHandler($e);
        }
    }

    /**
     * Obtener todas las recaladas
     */
    public function findAll() {
        try {
            $recaladas = \Recalada::all();
            $data = [];
    
            foreach ($recaladas as $recalada) {
                $data[] = [
                    'id' => $recalada->id ?? null,
                    'buque_id' => $recalada->buque_id ?? null,
                    'pais_id' => $recalada->pais_id ?? null,
                    'fecha_arribo' => isset($recalada->fecha_arribo) ? $recalada->fecha_arribo->format('Y-m-d H:i:s') : null,
                    'fecha_zarpe' => isset($recalada->fecha_zarpe) ? $recalada->fecha_zarpe->format('Y-m-d H:i:s') : null,
                    'total_turistas' => $recalada->total_turistas ?? 0,
                    'observaciones' => $recalada->observaciones ?? '',
                    'fecha_registro' => isset($recalada->fecha_registro) ? $recalada->fecha_registro->format('Y-m-d H:i:s') : null,
                    'usuario_registro' => $recalada->usuario_registro ?? null,
                ];
            }
    
            return $data;
        } catch (Exception $e) {
            throw \Utility::errorHandler($e);
        }
    }
    
    /**
     * Crear una recalada
     */
    public function create($buqueId, $paisId, $fechaArribo, $fechaZarpe, $totalTuristas, $observaciones, $usuarioRegistro) {
        try {
            $recalada = \Recalada::create([
                "fecha_arribo" => $fechaArribo->format('Y-m-d H:i:s'),
                "fecha_zarpe" => $fechaZarpe ? $fechaZarpe->format('Y-m-d H:i:s') : null,
                "total_turistas" => (int) $totalTuristas,
                "observaciones" => $observaciones,
                "buque_id" => $buqueId,
                "pais_id" => $paisId,
                "fecha_registro" => (new \DateTime())->format('Y-m-d H:i:s'),
                "usuario_registro" => (int) $usuarioRegistro
            ]);
            if (!$recalada) {
                throw new \Exception("No se pudo crear la recalada.");
            }
    
            error_log("[RecaladaMobileRepository] Recalada creada exitosamente: " . json_encode($recalada));
    
            return $recalada->to_array();
        } catch (Exception $e) {
            error_log("[RecaladaMobileRepository] Error al crear recalada: " . $e->getMessage());
            throw \Utility::errorHandler($e);
        }
    }
    
    /**
     * Obtener recaladas por buque
     */
    public function findByBuque($buqueId) {
        try {
            return \Recalada::find("all", ["conditions" => ["buque_id = ?", $buqueId]]);
        } catch (Exception $e) {
            throw \Utility::errorHandler($e);
        }
    }

    public function findRecaladaInThePort() {
        try {
            return \Recalada::find("all", [
                "conditions" => ["fecha_arribo <= ? AND fecha_zarpe >= ?", new \DateTime(), new \DateTime()]
            ]);
        } catch (\Exception $e) {
            throw new \Exception("Error al obtener recaladas en el puerto: " . $e->getMessage());
        }
    }
}
