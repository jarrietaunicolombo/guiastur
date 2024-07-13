<?php

interface IPaisRepository
{
    public function find(int $id): Pais;
    public function findAll(): array;
    public function create(Pais $pais): Pais;
    public function update(Pais $pais): Pais;
    public function delete(int $id): bool;
}
