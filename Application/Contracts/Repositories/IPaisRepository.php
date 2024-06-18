<?php

interface IPaisRepository
{
    public function find($id): Pais;
    public function findAll(): array;
    public function create(Pais $pais): Pais;
    public function update(Pais $pais): Pais;
    public function delete($id): bool;
}
