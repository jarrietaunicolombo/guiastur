<?php
interface IAtencionRepository
{
    public function find(int $id): Atencion;
    public function findAll(): array;
    public function create(Atencion $atencion): Atencion;
    public function update(Atencion $atencion): Atencion;
    public function delete(int $id): bool;
    public function validateAtencion(int $RecaladaId, DateTime $fecha, DateTime $fechaCierre): bool;
    public function findByRecalada(int $recaladaId): array;

}
