<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface DatabaseRepositoryInterface
{
    public function find(int $id): Model|null;

    public function index(): Collection|LengthAwarePaginator|array|null;

    public function create(array $params): Model|null;

    public function update(Model $entity, array $params): bool;

    public function delete(Model $entity): bool|null;
}
