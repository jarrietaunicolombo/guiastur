<?php

interface ISupervisorRepository
{
    public function find(string $cedula): Supervisor;
    public function findAll(): array;
    public function create(Supervisor $supervisor): Supervisor;
    public function update(Supervisor $supervisor);
    public function delete(string $cedula);
}
