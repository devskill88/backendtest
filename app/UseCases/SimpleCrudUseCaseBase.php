<?php

namespace App\UseCases;

use App\Repositories\DatabaseRepositoryInterface;

abstract class SimpleCrudUseCaseBase
{
    public DatabaseRepositoryInterface $repository;
    public $presenter;

    public function __construct()
    {
        $this->repository = static::repo();
    }

    abstract static function repo(): DatabaseRepositoryInterface;

    abstract static function render($data, string $message = '');
    
}