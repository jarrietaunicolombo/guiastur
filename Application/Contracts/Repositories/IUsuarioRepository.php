<?php

interface IUsuarioRepository
{
    public function find(int $id): Usuario;
    public function findByEmail(string $email): Usuario;
    public function findByToken(string $token): Usuario;
    public function findAll(): array;
    public function create(Usuario $usuario): Usuario;
    public function update(Usuario $usuario): Usuario;
    public function delete(int $id): bool;
}

