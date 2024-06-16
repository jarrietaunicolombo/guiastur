<?php

interface IRecaladaRepository
{
    public function find($id): Recalada;
    public function findAll(): array;
    public function create(Recalada $recalada): Recalada;
    public function update(Recalada $recalada): void;
    public function delete($id): void;
}
