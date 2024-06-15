<?php
interface UsuarioRepository
{
    public function find($id);
    public function findAll();
    public function create(Usuario $usuario);
    public function update(Usuario $usuario);
    public function delete($id);
}