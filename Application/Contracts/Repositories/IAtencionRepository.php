<?php
interface IAtencionRepository
{
    public function find($id): Atencion;
    public function findAll(): array;
    public function create(Atencion $atencion): Atencion;
    public function update(Atencion $atencion): Atencion;
    public function delete($id): bool;
    public function validateAtencion(int $RecaladaId, DateTime $fecha): bool;
    public function findByRecalada(int $recaladaId): array;

}
