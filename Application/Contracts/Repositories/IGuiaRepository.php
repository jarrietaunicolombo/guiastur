<?php

interface IGuiaRepository
{
    public function find($cedula): Guia;
    public function findAll(): array;
    public function create(Guia $guia): Guia;
    public function update(Guia $guia);
    public function delete($cedula);
}
