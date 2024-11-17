<?php

namespace Api\Services\Recaladas;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Recalada.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/NotFoundEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/DuplicateEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidRecaladaException.php";

use Api\Exceptions\RecaladasException;

class GetRecaladasService
{
    public function obtenerRecaladas()
    {
        try {
            $recaladas = \Recalada::find('all');

            foreach ($recaladas as $recalada) {
                error_log("Procesando recalada ID: " . $recalada->id);

                if ($recalada->buque) {
                    error_log("Buque encontrado: " . json_encode($recalada->buque));
                } else {
                    error_log("No se encontró buque para la recalada ID: " . $recalada->id);
                }

                if ($recalada->pais) {
                    error_log("País encontrado: " . json_encode($recalada->pais));
                } else {
                    error_log("No se encontró país para la recalada ID: " . $recalada->id);
                }

                $recalada->atencions = \Atencion::find('all', array('conditions' => array('recalada_id = ?', $recalada->id))) ?? [];
                error_log("Número de atenciones: " . count($recalada->atencions));

                $recaladasArray[] = [
                    'id' => $recalada->id,
                    'buque' => $recalada->buque ? $recalada->buque->nombre : 'N/A',
                    'pais' => $recalada->pais ? $recalada->pais->nombre : 'N/A',
                    'total_turistas' => $recalada->total_turistas,
                    'fecha_arribo' => $recalada->fecha_arribo,
                    'fecha_zarpe' => $recalada->fecha_zarpe,
                    'observaciones' => $recalada->observaciones,
                    'atenciones' => $recalada->atencions
                ];
            }

            return $recaladas;
        } catch (\NotFoundEntryException $e) {
            error_log("Error en GetRecaladasService: " . $e->getMessage());
            throw $e;
        } catch (\InvalidRecaladaException $e) {
            error_log("Error en GetRecaladasService: " . $e->getMessage());
            throw $e;
        } catch (\Exception $e) {
            error_log("Error en GetRecaladasService: " . $e->getMessage());
            throw new \Exception("Error inesperado al obtener recaladas");
        } catch (\Exception $e) {
            error_log("Error en GetRecaladasService: " . $e->getMessage());
            throw new RecaladasException("Error al obtener recaladas");
        }
    }
}
