<?php

interface ITurnoRepository
{
    public function find(int $id):  Turno;
    public function findAll(): array;
    public function create(Turno $turno): Turno;
    public function update(Turno $turno): Turno;
    public function delete(int $id): bool;
    public function findByAtencion(int $atencionId): array;
    public function findWithStateCreatedByAtencion(int $atencionId): array;
    public function findNexTurno(int $atencionId) : Turno;
    public function findNexTurnosAll(): array;
}
