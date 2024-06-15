<?php

interface BuqueRepository
{
    public function find($id);
    public function findAll();
    public function create(Buque $buque);
    public function update(Buque $buque);
    public function delete($id);
}
