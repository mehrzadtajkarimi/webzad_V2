<?php

namespace App\Models\Contracts;

interface CRUD
{
    public function create(array $data);
    public function find($id): object;
    public function all(): array;
    public function get($columns, array $where = null): array;
    public function update(array $data, array $where): int;
    public function delete(array $where): int;
}
