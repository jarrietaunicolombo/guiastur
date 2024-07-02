<?php

interface ITurnoRepository
{
    public function find($id):  Turno;
    public function findAll(): array;
    public function create(Turno $turno): Turno;
    public function update(Turno $turno): Turno;
    public function delete($id): bool;
    public function findByAtencion(int $atencionId): array;
    public function findWithStateCreatedByAtencion(int $atencionId): array;
    public function findNexTurno(int $atencionId) : Turno;
}
