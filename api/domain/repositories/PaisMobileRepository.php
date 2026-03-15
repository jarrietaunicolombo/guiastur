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
            $paises = \Pais::all();
    
            if (empty($paises)) {
                return ["status" => "success", "data" => []];
            }
    
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
                }
            }
    
            $jsonData = json_encode($data);
            if ($jsonData === false) {
                return ["status" => "error", "message" => "Error al procesar los datos"];
            }
    
            return [
                "status" => "success",
                "total" => count($data),
                "data" => $data
            ];
        } catch (Exception $e) {
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }

    /**
     * Obtener un país por su ID
     */
    public function findById($id) {
        try {
            $pais = \Pais::find($id);

            if (!$pais) {
                throw new Exception("País no encontrado.");
            }

            return [
                'id' => utf8_encode($pais->id ?? null),
                'nombre' => utf8_encode($pais->nombre ?? ''),
                'bandera' => utf8_encode($pais->bandera ?? ''),
                'fecha_registro' => isset($pais->fecha_registro) && $pais->fecha_registro instanceof \ActiveRecord\DateTime
                    ? $pais->fecha_registro->format('Y-m-d H:i:s')
                    : null,
                'usuario_registro' => utf8_encode($pais->usuario_registro ?? null)
            ];
        } catch (Exception $e) {
            throw new Exception("Error al obtener el país.");
        }
    }
}
