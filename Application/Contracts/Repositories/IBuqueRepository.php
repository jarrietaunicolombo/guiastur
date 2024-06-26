<?php

interface IBuqueRepository
{
    public function findById(int $id): Buque;
    public function findAll(): array;
    public function create(Buque $buque): Buque;
    public function update(Buque $buque): Buque;
    public function delete($id): bool;
}
