<?php

interface PaisRepository
{
    public function find($id);
    public function findAll();
    public function create(Pais $pais);
    public function update(Pais $pais);
    public function delete($id);
}
