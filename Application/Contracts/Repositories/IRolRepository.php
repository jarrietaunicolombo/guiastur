<?php

interface IRolRepository
{
    public function find($id): Rol;
    public function findAll(): array;
    public function create(Rol $rol): Rol;
    public function update(Rol $rol): Rol;
    public function delete($id): bool;
}
