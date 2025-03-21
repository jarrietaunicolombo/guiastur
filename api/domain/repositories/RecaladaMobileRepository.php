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
    
            $recalada = \Recalada::find($id);
    
            if (!$recalada) {
                return null;
            }
    
            // Obtener el nombre del buque
            $buque_nombre = $recalada->buque_id 
                ? (\Buque::find_by_id($recalada->buque_id)->nombre ?? "Sin buque") 
                : "Sin buque";
    
            // Obtener el nombre del país
            $pais_nombre = $recalada->pais_id 
                ? (\Pais::find_by_id($recalada->pais_id)->nombre ?? "No especificado") 
                : "No especificado";
    
            // Convertir a array incluyendo los nombres del buque y país
            $data = [
                'id' => $recalada->id ?? null,
                'buque_id' => $recalada->buque_id ?? null,
                'buque_nombre' => $buque_nombre,
                'pais_id' => $recalada->pais_id ?? null,
                'pais_nombre' => $pais_nombre,
                'fecha_arribo' => isset($recalada->fecha_arribo) ? $recalada->fecha_arribo->format('Y-m-d H:i:s') : null,
                'fecha_zarpe' => isset($recalada->fecha_zarpe) ? $recalada->fecha_zarpe->format('Y-m-d H:i:s') : null,
                'total_turistas' => $recalada->total_turistas ?? 0,
                'observaciones' => $recalada->observaciones ?? '',
                'fecha_registro' => isset($recalada->fecha_registro) ? $recalada->fecha_registro->format('Y-m-d H:i:s') : null,
                'usuario_registro' => $recalada->usuario_registro ?? null,
            ];
    
    
            return $data;
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
                    'buque_nombre' => $recalada->buque_id ? \Buque::find_by_id($recalada->buque_id)->nombre ?? "Sin buque" : "Sin buque",
                    'pais_id' => $recalada->pais_id ?? null,
                    'pais_nombre' => $recalada->pais_id ? \Pais::find_by_id($recalada->pais_id)->nombre ?? "No especificado" : "No especificado",
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
    
    
            return $recalada->to_array();
        } catch (Exception $e) {
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
            $fecha_actual = new \DateTime(); // Fecha actual para la consulta
    
            // Buscar recaladas activas en el puerto
            $recaladas = \Recalada::find("all", [
                "conditions" => [
                    "fecha_arribo <= ? AND fecha_zarpe >= ?",
                    $fecha_actual->format('Y-m-d H:i:s'),
                    $fecha_actual->format('Y-m-d H:i:s')
                ]
            ]);
    
            $data = [];
    
            foreach ($recaladas as $recalada) {
                // Obtener nombre del buque
                $buque_nombre = "Sin buque";
                if ($recalada->buque_id) {
                    $buque = \Buque::find_by_id($recalada->buque_id);
                    $buque_nombre = $buque ? $buque->nombre : "Sin buque";
                }
    
                // Obtener nombre del país
                $pais_nombre = "No especificado";
                if ($recalada->pais_id) {
                    $pais = \Pais::find_by_id($recalada->pais_id);
                    $pais_nombre = $pais ? $pais->nombre : "No especificado";
                }
    
                // Formatear fechas y manejar valores nulos
                $fecha_arribo = isset($recalada->fecha_arribo) && $recalada->fecha_arribo != null
                    ? $recalada->fecha_arribo->format('Y-m-d H:i:s')
                    : null;
    
                $fecha_zarpe = isset($recalada->fecha_zarpe) && $recalada->fecha_zarpe != null
                    ? $recalada->fecha_zarpe->format('Y-m-d H:i:s')
                    : null;
    
                // Manejo de valores nulos en total_turistas
                $total_turistas = $recalada->total_turistas ?? 0;
    
                // Construcción del array con los datos corregidos
                $data[] = [
                    'id' => $recalada->id ?? null,
                    'buque_id' => $recalada->buque_id ?? null,
                    'buque_nombre' => $buque_nombre,
                    'pais_id' => $recalada->pais_id ?? null,
                    'pais_nombre' => $pais_nombre,
                    'fecha_arribo' => $fecha_arribo,
                    'fecha_zarpe' => $fecha_zarpe,
                    'total_turistas' => $total_turistas,
                    'observaciones' => $recalada->observaciones ?? '',
                    'fecha_registro' => isset($recalada->fecha_registro) ? $recalada->fecha_registro->format('Y-m-d H:i:s') : null,
                    'usuario_registro' => $recalada->usuario_registro ?? null,
                ];
            }
    
            return $data; // Retornar recaladas activas con datos corregidos
        } catch (\Exception $e) {
            throw new \Exception("Error al obtener recaladas en el puerto: " . $e->getMessage());
        }
    }
}
