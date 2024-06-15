<?php
interface IAtencionRepository
{
    public function find($id): Atencion;
    public function findAll(): array;
    public function create(Atencion $atencion): Atencion;
    public function update(Atencion $atencion): void;
    public function delete($id): void;
}
