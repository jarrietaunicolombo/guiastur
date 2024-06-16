<?php

interface IUsuarioRepository
{
    public function find($id): Usuario;
    public function findAll(): array;
    public function create(Usuario $usuario): Usuario;
    public function update(Usuario $usuario): Usuario;
    public function delete($id): bool;
}

