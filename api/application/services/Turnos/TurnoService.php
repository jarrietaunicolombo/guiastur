<?php

namespace Api\Services\Turnos;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/api/domain/repositories/TurnoMobileRepository.php";

use Exception;
use Api\Domain\Repositories\Turnos\TurnoMobileRepository;

class TurnoService {
    private $turnoRepository;

    public function __construct() {
        $this->turnoRepository = new TurnoMobileRepository();
    }

    public function createTurno($data, $usuarioRegistro) {
        $this->validateCreateData($data);

        $turnoData = array_merge($data, [
            'fecha_registro' => (new \DateTime())->format('Y-m-d H:i:s'),
            'usuario_registro' => $usuarioRegistro
        ]);

        return $this->turnoRepository->create($turnoData);
    }

    public function useTurno($turnoId, $usuarioId, $observaciones = null) {
        $turno = $this->turnoRepository->findById($turnoId);
        $turno->estado = 'INUSE';
        $turno->fecha_uso = new \DateTime();
        $turno->usuario_uso = $usuarioId;

        if ($observaciones && !empty(trim($observaciones))) {
            $turno->observaciones = "Liberado: " . $observaciones;
        }

        return $this->turnoRepository->update($turno);
    }

    public function releaseTurno($turnoId, $usuarioId, $observaciones = null) {
        $turno = $this->turnoRepository->findById($turnoId);
        $turno->estado = 'RELEASE';
        $turno->fecha_salida = new \DateTime();
        $turno->usuario_salida = $usuarioId;

        if ($observaciones && !empty(trim($observaciones))) {
            $turno->observaciones = $turno->observaciones
                ? $turno->observaciones . ". Liberado: " . $observaciones
                : "Liberado: " . $observaciones;
        }

        return $this->turnoRepository->update($turno);
    }

    public function finishTurno($turnoId, $usuarioId, $observaciones = null) {
        $turno = $this->turnoRepository->findById($turnoId);
        $turno->estado = 'FINALIZED';
        $turno->fecha_regreso = new \DateTime();
        $turno->usuario_regreso = $usuarioId;

        if ($observaciones && !empty(trim($observaciones))) {
            $turno->observaciones = $turno->observaciones
                ? $turno->observaciones . ". Finalizado: " . $observaciones
                : "Finalizado: " . $observaciones;
        }

        return $this->turnoRepository->update($turno);
    }

    public function getTurnosByAtencion($atencionId) {
        return $this->turnoRepository->findByAtencion($atencionId);
    }

    private function validateCreateData($data) {
        if (!isset($data['numero']) || empty($data['numero'])) {
            throw new Exception("El número de turno es obligatorio.");
        }
        if (!isset($data['estado']) || empty($data['estado'])) {
            throw new Exception("El estado del turno es obligatorio.");
        }
        if (!isset($data['atencion_id']) || empty($data['atencion_id'])) {
            throw new Exception("El ID de atención es obligatorio.");
        }
    }
}
