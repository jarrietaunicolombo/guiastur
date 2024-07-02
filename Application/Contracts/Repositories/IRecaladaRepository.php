<?php

interface IRecaladaRepository
{
    public function find($id): Recalada;
    public function findAll(): array;
    public function create(Recalada $recalada): Recalada;
    public function update(Recalada $recalada): Recalada;
    public function delete($id): bool;
    public function validateRecalada(int $buqueId, DateTime $fecha): bool;
    public function findRecaladaInThePort(): array;
}
