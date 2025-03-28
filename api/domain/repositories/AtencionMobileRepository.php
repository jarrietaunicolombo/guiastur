<?php

namespace Api\Domain\Repositories\Atenciones;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Atencion.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Recalada.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/Exceptions/InvalidAtencionException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/application/Exceptions/DuplicateEntryException.php";

use Api\Exceptions\NotFoundEntryException;
use Api\Exceptions\DuplicateEntryException;
use Api\Exceptions\InvalidAtencionException;
use Exception;

class AtencionRepository
{
    public function find(int $id)
    {
        try {
            return \Atencion::find($id);
        } catch (Exception $e) {
            throw new NotFoundEntryException("Atención no encontrada con ID: $id");
        }
    }

    public function findActivas()
    {
        try {
            $ahora = new \DateTime();
            $atenciones = \Atencion::find("all", [
                "conditions" => ["fecha_cierre >= ?", $ahora->format("Y-m-d H:i:s")]
            ]);
    
            $data = [];
    
            foreach ($atenciones as $atencion) {
                // Buscar datos de recalada
                $recalada = \Recalada::find($atencion->recalada_id);
                $buqueNombre = $recalada && $recalada->buque_id
                    ? \Buque::find_by_id($recalada->buque_id)->nombre ?? 'Sin buque'
                    : 'Sin buque';
                $paisNombre = $recalada && $recalada->pais_id
                    ? \Pais::find_by_id($recalada->pais_id)->nombre ?? 'No especificado'
                    : 'No especificado';
    
                $data[] = [
                    'id' => $atencion->id,
                    'recalada_id' => $atencion->recalada_id,
                    'recalada' => [
                        'buque_nombre' => $buqueNombre,
                        'pais_nombre' => $paisNombre
                    ],
                    'fecha_inicio' => isset($atencion->fecha_inicio)
                        ? $atencion->fecha_inicio->format('Y-m-d H:i:s')
                        : null,
                    'fecha_cierre' => isset($atencion->fecha_cierre)
                        ? $atencion->fecha_cierre->format('Y-m-d H:i:s')
                        : null,
                    'total_turnos' => $atencion->total_turnos ?? 0,
                    'observaciones' => $atencion->observaciones ?? '',
                    'estado' => $atencion->fecha_cierre >= new \DateTime() ? 'Activa' : 'Cerrada'
                ];
            }
    
            return $data;
        } catch (Exception $e) {
            throw new Exception("Error al obtener las atenciones activas");
        }
    }

    public function findAll()
    {
        try {
            $atenciones = \Atencion::all();
            $data = [];
    
            foreach ($atenciones as $atencion) {
                // Buscar datos de recalada
                $recalada = \Recalada::find($atencion->recalada_id);
                $buqueNombre = $recalada && $recalada->buque_id ? \Buque::find_by_id($recalada->buque_id)->nombre ?? 'Sin buque' : 'Sin buque';
                $paisNombre = $recalada && $recalada->pais_id ? \Pais::find_by_id($recalada->pais_id)->nombre ?? 'No especificado' : 'No especificado';
    
                $data[] = [
                    'id' => $atencion->id,
                    'recalada_id' => $atencion->recalada_id,
                    'recalada' => [
                        'buque_nombre' => $buqueNombre,
                        'pais_nombre' => $paisNombre
                    ],
                    'fecha_inicio' => isset($atencion->fecha_inicio) ? $atencion->fecha_inicio->format('Y-m-d H:i:s') : null,
                    'fecha_cierre' => isset($atencion->fecha_cierre) ? $atencion->fecha_cierre->format('Y-m-d H:i:s') : null,
                    'total_turnos' => $atencion->total_turnos ?? 0,
                    'observaciones' => $atencion->observaciones ?? '',
                    'estado' => $atencion->fecha_cierre >= new \DateTime() ? 'Activa' : 'Cerrada'
                ];
            }
    
            return $data;
        } catch (Exception $e) {
            throw new Exception("Error al obtener las atenciones");
        }
    }

    public function create(array $data)
    {
        try {
            return \Atencion::create($data);
        } catch (Exception $e) {
            throw new DuplicateEntryException("La atención ya existe o hay un error en la creación.");
        }
    }

    public function update(\Atencion $atencion)
    {
        try {
            $this->find($atencion->id);
            $atencion->save();
            return $atencion;
        } catch (Exception $e) {
            throw new Exception("Error al actualizar la atención");
        }
    }

    public function delete(int $id)
    {
        try {
            $atencion = $this->find($id);
            return $atencion->delete();
        } catch (Exception $e) {
            throw new NotFoundEntryException("No se puede eliminar, atención no encontrada con ID: $id");
        }
    }

    public function validateNoCollision(int $recaladaId, \DateTime $fechaInicio, \DateTime $fechaCierre)
    {
        $atencion = \Atencion::find("first", [
            "conditions" => [
                "recalada_id = ? AND ? BETWEEN fecha_inicio AND fecha_cierre",
                $recaladaId, $fechaInicio
            ]
        ]);

        if ($atencion) {
            throw new InvalidAtencionException("La fecha de inicio se cruza con otra atención existente.");
        }

        $atencion = \Atencion::find("first", [
            "conditions" => [
                "recalada_id = ? AND ? BETWEEN fecha_inicio AND fecha_cierre",
                $recaladaId, $fechaCierre
            ]
        ]);

        if ($atencion) {
            throw new InvalidAtencionException("La fecha de cierre se cruza con otra atención existente.");
        }
    }
}
