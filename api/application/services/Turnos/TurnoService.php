<?php

namespace Api\Services\Turnos;

require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Domain/Entities/Turno.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/NumberTurnosExceededException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/DuplicateEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidFinishTurnoException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidUseTurnoException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Exceptions/InvalidReleaseTurnoException.php";

class TurnoService
{
    public function createTurno(array $data)
    {
        $this->validateTurnoAvailability($data['atencion_id'], $data['total_turnos']);
        $this->ensureGuiaDoesNotHaveTurno($data['atencion_id'], $data['guia_id']);

        $numero = $this->getNextTurnoNumero($data['atencion_id']);
        return $this->saveNewTurno($data, $numero);
    }

    public function getAllTurnos()
    {
        return \Turno::all();
    }

    public function finishTurno(int $turnoId, int $usuarioId)
    {
        $turno = $this->getTurnoIfReleased($turnoId);
        $this->checkPermission($usuarioId, $turno->guia_id);

        return $this->updateTurnoEstado($turno, 'FINISHED');
    }

    public function useTurno(int $turnoId, int $atencionId, int $usuarioId)
    {
        $turno = $this->getTurnoIfNext($turnoId, $atencionId);
        $this->checkPermission($usuarioId, $turno->guia_id);

        return $this->updateTurnoEstado($turno, 'IN_USE');
    }

    public function releaseTurno(int $turnoId, int $usuarioId)
    {
        $turno = $this->getTurnoIfInUse($turnoId);
        $this->checkPermission($usuarioId, $turno->guia_id);

        return $this->updateTurnoEstado($turno, 'AVAILABLE');
    }

    public function getTurnosByAtenciones(int $atencionId)
    {
        return \Turno::find('all', ['conditions' => ['atencion_id' => $atencionId]]);
    }

    public function getTurnosByStatus(string $estado)
    {
        return \Turno::find('all', ['conditions' => ['estado' => $estado]]);
    }

    // Métodos auxiliares

    private function validateTurnoAvailability(int $atencionId, int $totalTurnos)
    {
        $turnos = \Turno::find('all', ['conditions' => ['atencion_id' => $atencionId]]);
        if (count($turnos) >= $totalTurnos) {
            throw new \NumberTurnosExceededException("No existen turnos disponibles para la Atencion $atencionId");
        }
    }

    private function ensureGuiaDoesNotHaveTurno(int $atencionId, int $guiaId)
    {
        $turnos = \Turno::find('all', ['conditions' => ['atencion_id' => $atencionId]]);
        foreach ($turnos as $turno) {
            if ($turno->guia_id == $guiaId) {
                throw new \DuplicateEntryException("El guia Id: $guiaId tiene un turno previamente programado para la Atencion $atencionId");
            }
        }
    }

    private function getNextTurnoNumero(int $atencionId): int
    {
        $turnos = \Turno::find('all', ['conditions' => ['atencion_id' => $atencionId]]);
        return (count($turnos) > 0) ? end($turnos)->numero + 1 : 1;
    }

    private function saveNewTurno(array $data, int $numero)
    {
        return \Turno::create([
            'numero' => $numero,
            'estado' => 'CREATED',
            'observaciones' => $data['observaciones'],
            'guia_id' => $data['guia_id'],
            'atencion_id' => $data['atencion_id'],
            'usuario_registro' => $data['usuario_registro']
        ]);
    }

    private function getTurnoIfReleased(int $turnoId)
    {
        $turno = \Turno::find($turnoId);
        if ($turno->estado !== 'RELEASE') {
            throw new \InvalidFinishTurnoException("El Turno #: {$turno->numero} no fue liberado");
        }
        return $turno;
    }

    private function getTurnoIfNext(int $turnoId, int $atencionId)
    {
        $nextTurno = \Turno::find('first', ['conditions' => ['atencion_id' => $atencionId, 'estado' => 'CREATED']]);
        if ($turnoId != $nextTurno->id) {
            throw new \InvalidUseTurnoException("Uso de turno rechazado, Proximo Turno Numero: {$nextTurno->numero}");
        }
        return \Turno::find($turnoId);
    }

    private function getTurnoIfInUse(int $turnoId)
    {
        $turno = \Turno::find($turnoId);
        if ($turno->estado !== 'IN_USE') {
            throw new \InvalidReleaseTurnoException("No se puede liberar el Turno #: {$turno->numero}, el turno no está en uso");
        }
        return $turno;
    }

    private function updateTurnoEstado($turno, string $estado)
    {
        $turno->update_attributes(['estado' => $estado]);
        return $turno;
    }

    private function checkPermission(int $usuarioId, int $guiaId): void
    {
        if ($usuarioId !== $guiaId) {
            throw new \InvalidReleaseTurnoException("No tiene permisos para esta acción en el turno del Guia {$guiaId}");
        }
    }
}
