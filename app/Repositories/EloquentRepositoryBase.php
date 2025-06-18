<?php

namespace App\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentRepositoryBase
{
    public Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function find(int $id): Model|null
    {
        return $this->model::find($id);
    }

    public function index(): Collection|LengthAwarePaginator|array|null
    {
        if (request()->q) {
            return $this->filterResults();
        }

        $query = $this->model->orderBy('created_at', 'desc');

        $perPage = request()->disablePaginate ? 9999 : request()->per_page;
        return $query->paginate($perPage);
    }

    public function create(array $params): Model|null
    {
        return $this->model->create($params);
    }

    public function update(Model $entity, array $params): bool
    {
        return $entity->update($params);
    }

    public function delete(Model $entity): bool|null
    {
        return $entity->delete();
    }

    protected function filterResults(): Collection|LengthAwarePaginator|array|null
    {
        $query = $this->model;
        $filters = isset($this->model->filterable) ? $this->model->filterable : $this->model->getFillable();
        foreach ($filters as $filter) {
            $query = $query->orWhere($filter, 'like', '%' . request()->q . '%');
        }
        $perPage = request()->disablePaginate ? 9999 : request()->per_page;
        return $query->paginate($perPage);
    }
}
