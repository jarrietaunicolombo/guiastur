<?php

interface IPaisRepository
{
    public function find($id): Pais;
    public function findAll(): array;
    public function create(Pais $pais): Pais;
    public function update(Pais $pais): void;
    public function delete($id): void;
}
