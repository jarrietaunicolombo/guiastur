<?php

interface ITurnoRepository
{
    public function find($id): ?Turno;
    public function findAll(): array;
    public function create(Turno $turno): Turno;
    public function update(Turno $turno): void;
    public function delete($id): void;
}
