<?php
interface SupervisorRepository
{
    public function find($cedula);
    public function findAll();
    public function create(Supervisor $supervisor);
    public function update(Supervisor $supervisor);
    public function delete($cedula);
}
