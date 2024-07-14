<?php

interface IRecaladaRepository
{
    public function find(int $id): Recalada;
    public function findAll(): array;
    public function create(Recalada $recalada): Recalada;
    public function update(Recalada $recalada): Recalada;
    public function delete(int $id): bool;
    public function validateRecalada(int $buqueId, DateTime $fecha): bool;
    public function findRecaladaInThePort(): array;
    public function findByBuqueId(int $buqueId): array;
}
