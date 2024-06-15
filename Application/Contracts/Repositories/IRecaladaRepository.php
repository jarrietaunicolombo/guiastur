<?php

interface RecaladaRepository
{
    public function find($id);
    public function findAll();
    public function create(Recalada $recalada);
    public function update(Recalada $recalada);
    public function delete($id);
}


