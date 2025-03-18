<?php

namespace Api\Repositories;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Pais.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/NotFoundEntryException.php";

use Exception;

class PaisMobileRepository {
    /**
     * Obtener todos los países
     */
    public function findAll() {
        try {
            error_log("[PaisMobileRepository] findAll() llamado");
    
            // Obtener los países desde ActiveRecord
            $paises = \Pais::all();
    
            error_log("[PaisMobileRepository] Países obtenidos (crudos): " . print_r($paises, true));
    
            // Verificar si hay datos
            if (empty($paises)) {
                error_log("[PaisMobileRepository] No se encontraron países");
                return ["status" => "success", "data" => []];
            }
    
            // Convertir los objetos ActiveRecord a arrays asociativos con UTF-8
            $data = [];
            foreach ($paises as $pais) {
                try {
                    $data[] = [
                        'id' => utf8_encode($pais->id ?? null),
                        'nombre' => utf8_encode($pais->nombre ?? ''),
                        'bandera' => utf8_encode($pais->bandera ?? ''),
                        'fecha_registro' => isset($pais->fecha_registro) && $pais->fecha_registro instanceof \ActiveRecord\DateTime
                            ? $pais->fecha_registro->format('Y-m-d H:i:s')
                            : null,
                        'usuario_registro' => utf8_encode($pais->usuario_registro ?? null)
                    ];
                } catch (Exception $ex) {
                    error_log("[PaisMobileRepository] Error formateando país con ID " . ($pais->id ?? "Desconocido") . ": " . $ex->getMessage());
                }
            }
    
            // Verificar si json_encode está fallando
            $jsonData = json_encode($data);
            if ($jsonData === false) {
                error_log("[PaisMobileRepository] ERROR al convertir datos a JSON: " . json_last_error_msg());
                return ["status" => "error", "message" => "Error al procesar los datos"];
            }
    
            // Log para verificar si los datos se formatearon correctamente
            error_log("[PaisMobileRepository] Países formateados correctamente: " . $jsonData);
    
            return [
                "status" => "success",
                "total" => count($data),
                "data" => $data
            ];
        } catch (Exception $e) {
            error_log("[PaisMobileRepository] ERROR en findAll(): " . $e->getMessage());
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }
    
}
