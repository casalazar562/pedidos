<?php

namespace App\Contracts;

interface RepositoryInterface
{
    public function list();

    public function create(array $data);

    public function update(array $data, int $id);

    public function delete(int $id);

    public function find(int $id);
}
