<?php

interface IRolRepository
{
    public function find(int $id): Rol;
    public function findAll(): array;
    public function create(Rol $rol): Rol;
    public function update(Rol $rol): Rol;
    public function delete(int $id): bool;
}
