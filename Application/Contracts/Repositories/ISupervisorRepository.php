<?php

interface ISupervisorRepository
{
    public function find($cedula): Supervisor;
    public function findAll(): array;
    public function create(Supervisor $supervisor): Supervisor;
    public function update(Supervisor $supervisor);
    public function delete($cedula);
}
