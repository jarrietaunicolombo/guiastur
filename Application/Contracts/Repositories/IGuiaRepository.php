<?php

interface GuiaRepository
{
    public function find($cedula);
    public function findAll();
    public function create(Guia $guia);
    public function update(Guia $guia);
    public function delete($cedula);
}
