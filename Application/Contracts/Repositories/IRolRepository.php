<?php

interface RolRepository
{
    public function find($id);
    public function findAll();
    public function create(Rol $rol);
    public function update(Rol $rol);
    public function delete($id);
}

