<?php

interface AtencionRepository
{
    public function find($id);
    public function findAll();
    public function create(Atencion $atencion);
    public function update(Atencion $atencion);
    public function delete($id);
}
