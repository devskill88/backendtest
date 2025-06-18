<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class SimpleEntityCrudController extends Controller
{

    protected $useCase;
    protected $resource;
    public $storagePath = 'default';

    public function index()
    {
        $entities = $this->useCase->repository->index();
        return $this->useCase::render($this->resource::collection($entities));
    }

    public function show(Request $request)
    {
        $entity = $this->useCase->repository->find($request->id);
        return $this->useCase::render(new $this->resource($entity));
    }

    public function store(Request $request)
    {
        $entity = $this->useCase->repository->create($request->validated());
        return $this->useCase::render(app()->make($this->resource, ['resource' => $entity]));
    }

    public function save($request, Model $entity)
    {
        $this->useCase->repository->update($entity, $request->validated());

        return $this->useCase::render('', 'Entity updated successfully');
    }

    public function delete(Model $entity)
    {
        $this->useCase->repository->delete($entity);
        return $this->useCase::render([], 'Entity deleted successfully');
    }
}
